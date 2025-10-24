// story-modal.js
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('story-modal');
    const items = document.querySelectorAll('.story-default-item');
    const slides = modal.querySelectorAll('.slides li');
    const modalContent = modal.querySelector('.modal-content');

    let currentIndex = 0;
    let progressInterval = null;
    let autoNextTimeout = null;
    const DURATION = 10000;

    // Build progress bars
    const progressContainer = document.createElement('div');
    progressContainer.className = 'progress-container';
    modalContent.prepend(progressContainer);

    slides.forEach(() => {
        const bar = document.createElement('div');
        bar.className = 'progress-bar';
        bar.innerHTML = '<div class="fill"></div>';
        progressContainer.appendChild(bar);
    });
    const progressBars = progressContainer.querySelectorAll('.progress-bar');

    // Open modal
    items.forEach((item, i) => {
        item.addEventListener('click', () => {
            currentIndex = i;
            openModal();
        });
    });

    function openModal() {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        showSlide(currentIndex);
    }

    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
        stopAutoPlay();
        resetProgress();
        pauseAllVideos();
    }

    function showSlide(index) {
        slides.forEach((s, i) => s.classList.toggle('active', i === index));
        updateProgress(index);
        playCurrentVideo();
        startAutoPlay();
    }

    function startAutoPlay() {
        stopAutoPlay();
        const fill = progressBars[currentIndex].querySelector('.fill');
        let width = 0;
        const step = 100 / (DURATION / 50);

        progressInterval = setInterval(() => {
            width += step;
            fill.style.width = width + '%';
            if (width >= 100) goNext();
        }, 50);

        autoNextTimeout = setTimeout(goNext, DURATION);
    }

    function stopAutoPlay() {
        clearInterval(progressInterval);
        clearTimeout(autoNextTimeout);
    }

    function updateProgress(activeIdx) {
        progressBars.forEach((bar, i) => {
            const fill = bar.querySelector('.fill');
            fill.style.width = i < activeIdx ? '100%' : i === activeIdx ? '0%' : '0%';
        });
    }

    function resetProgress() {
        progressBars.forEach(bar => bar.querySelector('.fill').style.width = '0%');
    }

    function goNext() {
        stopAutoPlay();
        if (currentIndex < slides.length - 1) {
            currentIndex++;
            showSlide(currentIndex);
        } else {
            closeModal();
        }
    }

    function goPrev() {
        stopAutoPlay();
        if (currentIndex > 0) {
            currentIndex--;
            showSlide(currentIndex);
        }
    }

    function playCurrentVideo() {
        pauseAllVideos();
        const video = slides[currentIndex].querySelector('video');
        if (video) {
            video.currentTime = 0;
            video.play().catch(() => {});
        }
    }

    function pauseAllVideos() {
        slides.forEach(s => {
            const v = s.querySelector('video');
            if (v) {
                v.pause();
                v.currentTime = 0;
            }
        });
    }

    // Navigation zones
    const prevZone = document.createElement('div');
    const nextZone = document.createElement('div');
    prevZone.className = 'nav-zone prev';
    nextZone.className = 'nav-zone next';
    modalContent.append(prevZone, nextZone);

    modalContent.addEventListener('click', e => {
        if (e.target.closest('.nav-zone.prev')) goPrev();
        else if (e.target.closest('.nav-zone.next')) goNext();
        else if (e.target.closest('.close-btn')) closeModal();
        else if (!e.target.closest('.modal-content > *')) closeModal();
    });

    // Close button
    const closeBtn = document.createElement('div');
    closeBtn.className = 'close-btn';
    closeBtn.innerHTML = '×';
    modalContent.appendChild(closeBtn);

    // Keyboard
    document.addEventListener('keydown', e => {
        if (!modal.classList.contains('active')) return;
        if (e.key === 'Escape') closeModal();
        if (e.key === 'ArrowRight') goNext();
        if (e.key === 'ArrowLeft') goPrev();
    });
});
