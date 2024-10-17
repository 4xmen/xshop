class ContentSEOAnalyzer {
    constructor(content, targetKeyword) {
        this.content = content;
        this.targetKeyword = targetKeyword.toLowerCase();
        this.plainText = this.stripHTML(content);
        this.sentences = this.getSentences();
        this.paragraphs = this.getParagraphs();
        this.wordCount = this.getWordCount();
    }

    // Remove HTML tags and get plain text
    stripHTML(html) {
        return html.replace(/<[^>]*>/g, ' ')
            .replace(/\s+/g, ' ')
            .trim();
    }

    // Improved sentence detection for mixed content
    getSentences() {
        // First clean the text from extra spaces and normalize punctuation
        let text = this.plainText
            .replace(/\s+/g, ' ')
            .replace(/[\u200B-\u200D\uFEFF]/g, ''); // Remove zero-width spaces

        // Handle both RTL and LTR sentence endings
        // Added more Arabic/Persian punctuation marks
        const sentenceEndings = [
            '.',  // English period
            '!',  // English exclamation
            '?',  // English question mark
            '؟',  // Arabic question mark
            '।',  // Arabic full stop
            '۔',  // Urdu full stop
            '،',  // Arabic comma when followed by a new sentence
            ';',  // English semicolon when used as sentence separator
            '؛',  // Arabic semicolon
        ];

        // Create a regex pattern that matches any of these endings
        // followed by a space and either:
        // 1. An uppercase letter (for English)
        // 2. An Arabic/Persian letter
        // 3. A number (for both scripts)
        const pattern = new RegExp(
            `([${sentenceEndings.join('')}])\\s*(?=[A-Z\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF0-9])`,
            'g'
        );

        // Split into sentences
        let sentences = text
            .replace(pattern, '$1|')
            .split('|')
            .map(sentence => sentence.trim())
            .filter(sentence => {
                // Remove empty sentences and very short ones (less than 2 words)
                const words = sentence.split(/\s+/);
                return sentence.length > 0 && words.length >= 2;
            });

        // Additional cleaning: merge incorrectly split sentences
        sentences = this.cleanSentences(sentences);

        return sentences;
    }

    // Helper method to clean and merge sentences that might have been incorrectly split
    cleanSentences(sentences) {
        const cleaned = [];
        let current = '';

        for (let sentence of sentences) {
            // Check if sentence starts with lowercase or is very short
            if (current && (
                sentence.charAt(0).match(/[a-z]/) || // Starts with lowercase
                sentence.length < 10 || // Very short
                /^[و،]/.test(sentence) // Starts with Arabic 'and' or comma
            )) {
                current += ' ' + sentence;
            } else {
                if (current) {
                    cleaned.push(current.trim());
                }
                current = sentence;
            }
        }

        // Don't forget to add the last sentence
        if (current) {
            cleaned.push(current.trim());
        }

        // Final filtering to remove any remaining invalid sentences
        return cleaned.filter(sentence => {
            // Ensure minimum length and word count
            const words = sentence.split(/\s+/);
            return sentence.length >= 10 && words.length >= 2;
        });
    }

    // Adjust the readability analysis to be more accurate with the new sentence detection
    analyzeReadability() {
        const avgSentenceLength = this.sentences.length ?
            this.wordCount / this.sentences.length : 0;

        const avgParagraphLength = this.paragraphs.length ?
            this.wordCount / this.paragraphs.length : 0;

        // Increased threshold for complex sentences
        const complexSentences = this.sentences.filter(sentence =>
            sentence.split(/\s+/).filter(word => word.length > 0).length > 25
        ).length;

        const complexSentencePercentage = this.sentences.length ?
            (complexSentences / this.sentences.length) * 100 : 0;

        return {
            avgSentenceLength,
            avgParagraphLength,
            complexSentencePercentage,
            totalParagraphs: this.paragraphs.length,
            totalSentences: this.sentences.length
        };
    }

    // Helper method to calculate statistical variation in sentence lengths
    calculateVariation(lengths) {
        if (lengths.length < 2) return 0;
        const mean = lengths.reduce((sum, val) => sum + val, 0) / lengths.length;
        const variance = lengths.reduce((sum, val) => sum + Math.pow(val - mean, 2), 0) / lengths.length;
        return Math.sqrt(variance);
    }

    // Calculate a more nuanced readability score
    calculateReadabilityScore(sentenceLengths) {
        if (sentenceLengths.length === 0) return 0;

        const avg = sentenceLengths.reduce((sum, len) => sum + len, 0) / sentenceLengths.length;
        const variation = this.calculateVariation(sentenceLengths);

        // Ideal ranges:
        // Average sentence length: 15-20 words
        // Variation: 5-10 words (some variety but not too much)
        let score = 10;

        // Penalize for extreme average lengths
        if (avg < 10) score -= 2;
        else if (avg > 25) score -= 2;
        else if (avg > 20) score -= 1;

        // Penalize for too much or too little variation
        if (variation < 3) score -= 1; // Too monotonous
        else if (variation > 15) score -= 1; // Too varied

        return Math.max(0, Math.min(10, score));
    }

    // Get paragraphs from content
    getParagraphs() {
        return this.content
            .split(/<\/p>|<\/div>|<br\s*\/?>|\n/)
            .map(p => this.stripHTML(p))
            .filter(p => p.trim().length > 0);
    }

    // Get word count
    getWordCount() {
        return this.plainText.split(/\s+/).filter(word => word.length > 0).length;
    }

    // Calculate average sentence length
    getAverageSentenceLength() {
        if (this.sentences.length === 0) return 0;
        const totalWords = this.sentences
            .map(sentence => sentence.split(/\s+/).filter(word => word.length > 0).length)
            .reduce((sum, length) => sum + length, 0);
        return totalWords / this.sentences.length;
    }

    // Calculate average paragraph length
    getAverageParagraphLength() {
        if (this.paragraphs.length === 0) return 0;
        const totalWords = this.paragraphs
            .map(para => para.split(/\s+/).filter(word => word.length > 0).length)
            .reduce((sum, length) => sum + length, 0);
        return totalWords / this.paragraphs.length;
    }

    // Analyze keyword usage
    analyzeKeyword() {

        // Check keyword size
        let shortKeyword = false;
        if (this.targetKeyword.length < 2){
            shortKeyword =  true;
        }
        const keywordCount = (this.plainText.toLowerCase().match(new RegExp(this.targetKeyword, 'g')) || []).length;
        const density = (keywordCount / this.wordCount) * 100;

        // Check keyword in first paragraph
        const firstParagraphHasKeyword = this.paragraphs[0]?.toLowerCase().includes(this.targetKeyword);

        // Check keyword in headings
        const headings = this.content.match(/<h[1-6][^>]*>(.*?)<\/h[1-6]>/gi) || [];
        const headingsWithKeyword = headings.filter(h =>
            this.stripHTML(h).toLowerCase().includes(this.targetKeyword)
        ).length;

        return {
            count: keywordCount,
            density,
            firstParagraphHasKeyword,
            headingsWithKeyword,
            shortKeyword: shortKeyword,
        };
    }


    // Generate analysis report with 0-10 rating
    generateReport() {
        const keywordAnalysis = this.analyzeKeyword();
        const readabilityAnalysis = this.analyzeReadability();

        let score = 0;
        const feedback = [];

        // Score components (each component adds up to 10)

        // 1. Content Length (2 points)
        if (this.wordCount >= 300) score += 2;
        else feedback.push(window.TR.contentShort);

        // 2. Keyword Usage (2 points)
        if (keywordAnalysis.density >= 0.5 && keywordAnalysis.density <= 2.5) score += 0.5;
        if (keywordAnalysis.firstParagraphHasKeyword) score += 0.5;
        if (keywordAnalysis.headingsWithKeyword > 0) score += 1;
        if (keywordAnalysis.count >= 2) score += 0;

        if (keywordAnalysis.density < 0.5) feedback.push(window.TR.destinyLow);
        if (keywordAnalysis.density > 3.5) feedback.push(window.TR.destinyHigh);
        if (keywordAnalysis.shortKeyword) feedback.push(window.TR.shortKeyword);
        if (!keywordAnalysis.firstParagraphHasKeyword) feedback.push(window.TR.keywordFirstParagraph);
        if (keywordAnalysis.headingsWithKeyword === 0) feedback.push(window.TR.keywordHeading);

        // 3. Readability (4 points)
        if (readabilityAnalysis.avgSentenceLength <= 30) score += 1;
        if (readabilityAnalysis.avgParagraphLength <= 150) score += 1;
        if (readabilityAnalysis.complexSentencePercentage <= 25) score += 1;
        if (this.paragraphs.length >= 3) score += 1;

        if (readabilityAnalysis.avgSentenceLength > 30) feedback.push(window.TR.sentencesLong);
        if (readabilityAnalysis.avgParagraphLength > 150) feedback.push(window.TR.paragraphsLong);
        if (readabilityAnalysis.complexSentencePercentage > 25) feedback.push(window.TR.sentencesComplex);
        if (this.paragraphs.length < 3) feedback.push(window.TR.paragraphAdd);

        // 4. Structure & Formatting (2 points)
        const hasHeadings = /<h[1-6][^>]*>/i.test(this.content);
        const hasLists = /<[ou]l[^>]*>/i.test(this.content);

        if (hasHeadings) score += 1;
        if (hasLists) score += 1;

        if (!hasHeadings) feedback.push(window.TR.headingAdd );
        if (!hasLists) feedback.push(window.TR.useList);

        console.log(readabilityAnalysis);
        return {
            score: Math.min(10, Math.round(score * 10) / 10),
            feedback,
            details: {
                wordCount: this.wordCount,
                keywordUsage: {
                    count: keywordAnalysis.count,
                    density: `${keywordAnalysis.density.toFixed(1)}%`,
                    inFirstParagraph: keywordAnalysis.firstParagraphHasKeyword,
                    inHeadings: keywordAnalysis.headingsWithKeyword
                },
                readability: {
                    avgWordsPerSentence: Math.round(readabilityAnalysis.avgSentenceLength),
                    avgWordsPerParagraph: Math.round(readabilityAnalysis.avgParagraphLength),
                    complexSentences: `${readabilityAnalysis.complexSentencePercentage.toFixed(1)}%`,
                    paragraphCount: readabilityAnalysis.totalParagraphs
                }
            }
        };
    }



// Function to determine score status
    getScoreStatus(score) {
        if (score >= 7) return { class: 'good', text: window.TR.good };
        if (score >= 5) return { class: 'average', text: window.TR.averageNeeed };
        return { class: 'poor', text:  window.TR.poor   };
    }

// Function to create and display the report
    displaySEOReport(report, targetElement) {
        // // Add styles to document if not already present
        // if (!document.getElementById('seo-report-styles')) {
        //     const styleSheet = document.createElement('style');
        //     styleSheet.id = 'seo-report-styles';
        //     styleSheet.textContent = styles;
        //     document.head.appendChild(styleSheet);
        // }

        const scoreStatus = this.getScoreStatus(report.score);

        const reportHTML = `
        <div class="seo-report">
            <div class="seo-score-container">
                <div class="seo-score">
                    <div class="seo-score-circle ${scoreStatus.class}">
                        ${report.score.toFixed(1)}
                    </div>
                </div>
                <div class="seo-status">
                    <h3>${ window.TR.SEOScore}: ${scoreStatus.text}</h3>
                    <p>${window.TR.basedOnKeyword}</p>
                </div>
            </div>

            <div class="seo-details">
                <div class="seo-feedback">
                    <h4>${window.TR.recommendations}</h4>
                    <ul>
                        ${report.feedback.map(item => `<li>${item}</li>`).join('')}
                    </ul>
                </div>

                <div class="seo-metrics">
                    <div class="metric-card">
                        <h4>${window.TR.contentLength}</h4>
                        <div class="metric-value">${report.details.wordCount} ${ window.TR.words}</div>
                    </div>

                    <div class="metric-card">
                        <h4>${window.TR.keywordUsage}</h4>
                        <div class="metric-value">
                            ${report.details.keywordUsage.count} ${ window.TR.times}
                            (${report.details.keywordUsage.density})
                        </div>
                    </div>

                    <div class="metric-card">
                        <h4>${window.TR.avgSenLen}</h4>
                        <div class="metric-value">
                            ${report.details.readability.avgWordsPerSentence} ${ window.TR.words}
                        </div>
                    </div>

                    <div class="metric-card">
                        <h4>${window.TR.avgParaStruc}</h4>
                        <div class="metric-value">
                            ${report.details.readability.paragraphCount} ${ window.TR.paragraphs}
                            (${window.TR.avg} ${report.details.readability.avgWordsPerParagraph} ${ window.TR.words})
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

        const targetDiv = document.getElementById(targetElement);
        if (targetDiv) {
            targetDiv.innerHTML = reportHTML;
        }
    }
}

export default ContentSEOAnalyzer;
