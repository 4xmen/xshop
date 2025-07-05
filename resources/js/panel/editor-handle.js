import ContentSEOAnalyzer from './seo-analyzer.js'

let timeOut = null;
window.addEventListener('load', function () {

    try {

        if (document.querySelectorAll('.ckeditorx[name="description"]').length > 0){
            let metaDescription = document.querySelector('meta[name="description"]');
            if (metaDescription) {
                metaDescription.remove();
            }
        }

        let keywordInput = document.querySelector('#keyword');
        let dirx = document.querySelector('#panel-dir').value;
        let editors = {};
        document.querySelectorAll('.ckeditorx')?.forEach(function (el) {

            const currentDir = el.getAttribute('dir');
            let finalDir = dirx;
            if (currentDir != null) {
                finalDir = currentDir;
            }
            editors[el.getAttribute('name')] = CKEDITOR.replace(el.getAttribute('name'), {
                filebrowserUploadUrl: xupload,
                filebrowserUploadMethod: 'form',
                contentsLangDirection: finalDir,
                skin: 'moono-dark',
                removeButtons: 'Font',
                // font_names:
                //     'Arial/Arial, Helvetica, sans-serif;' +
                //     'Georgia/Georgia, serif;'
            });


            CKEDITOR.addCss('.cke_editable { background-color: ' + website_bg + '; color: ' + website_text_color + ' ; font-family: ' + website_font + '; font-weight: 500; } .cke_editable strong{ font-weight: 700} ');
            editors[el.getAttribute('name')].on('change', function (evt) {
                const content = evt.editor.getData();
                el.value = content;
                if (el.classList.contains('seo-analyze')) {
                    let keyword = keywordInput?.value;

                    const analyzer = new ContentSEOAnalyzer(content, keyword);
                    const report = analyzer.generateReport();
                    analyzer.displaySEOReport(report, 'seo-hint')
                }
            });


            if (el.classList.contains('seo-analyze')) {
                editors[el.getAttribute('name')].fire('change');
                keywordInput?.addEventListener('input', function () {
                    editors[el.getAttribute('name')].fire('change');
                });
            }

        });

    } catch {
    }
});
