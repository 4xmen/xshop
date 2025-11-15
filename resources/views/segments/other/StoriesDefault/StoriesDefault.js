// story-modal.js
document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('story-modal');
    if (modal == null) {
        return ;
    }
    const items = document.querySelectorAll('.story-default-item');
    const slides = modal.querySelectorAll('.slides li');
    const modalContent = modal.querySelector('.modal-content');

    let currentIndex = 0;
    let progressInterval = null;
    let autoNextTimeout = null;
    const DURATION = parseInt(document.querySelector('#def-story-timeout').value) * 1000;

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
            video.play().catch(() => {
            });
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
    closeBtn.innerHTML = '<i class="ri-close-line"></i>';
    modalContent.appendChild(closeBtn);

    // Keyboard
    document.addEventListener('keydown', e => {
        if (!modal.classList.contains('active')) return;
        if (e.key === 'Escape') closeModal();
        if (e.key === 'ArrowRight') goNext();
        if (e.key === 'ArrowLeft') goPrev();
    });

    document.querySelector('#story-modal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeModal();
        }
    });

    document.querySelectorAll('#story-modal input')?.forEach(el => {
        el.addEventListener('focus', function (e) {
            stopAutoPlay();
        })
        el.addEventListener('blur', function (e) {
            startAutoPlay();
        })
    });

    document.querySelectorAll('#story-modal .send-story-comment')?.forEach(function (el) {
        el.addEventListener('click', async (e) => {
           e.preventDefault();
           const url = document.querySelector('#story-comment-url').value;
           const data = {
               commentable_type: 'App\\Models\\Story',
               commentable_id: el.getAttribute('data-id'),
               message: el.closest('.input-group').querySelector('input').value,
               parent_id: null,
           };
            let resp;
           try {
                resp =  await axios.post(url,data);
                if (resp.data.OK){
                    window.$toast.success(resp.data.message);
                    el.closest('.input-group').querySelector('input').value = '';
                }else {
                    window.$toast.error(resp.data.message);
                }
            } catch(e) {
               if (e.response) {
                   // The request was made and the server responded with a status code
                   // that falls out of the range of 2xx
                   if (e.response.status === 422) {
                       // Laravel validation errors
                       const errors = e.response.data.errors;
                       if (errors) {
                           // Display first error message or concatenate multiple errors
                           const errorMessage = Object.values(errors)[0][0];
                           window.$toast.error(errorMessage);
                       } else {
                           // Fallback error message
                           window.$toast.error(e.response.data.message || 'Validation failed');
                       }
                   } else {
                       // Other error status codes
                       window.$toast.error(e.response.data.message || 'An error occurred');
                   }
               } else if (e.request) {
                   // The request was made but no response was received
                   window.$toast.error('No response from server');
               } else {
                   // Something happened in setting up the request that triggered an Error
                   window.$toast.error('Error in request setup');
               }
            }

        });
    });
    document.querySelectorAll('#story-modal .like')?.forEach(function (el) {

        let i = el.querySelector('i');
        el.addEventListener('mouseenter', function (e) {
            i.classList.add('ri-heart-fill');
            i.classList.remove('ri-heart-line');
            i.style.color = 'red';
        });
        el.addEventListener('mouseleave', function (e) {
            i.classList.add('ri-heart-line');
            i.classList.remove('ri-heart-fill');
            i.style.color = '';
        });
        el.addEventListener('click', async function (e) {
            const url = document.querySelector('#like-url').value;
            let resp =  await axios.post(url,{id: this.getAttribute('data-id')});
            if (resp.data.OK){
                window.$toast.success(resp.data.message);
                el.querySelector('b').innerText =  ( parseInt(el.querySelector('b').innerText) + 1).toString();
            }else {
                window.$toast.error(resp.data.message);
            }
        });
    });


});
