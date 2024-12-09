document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.autoplay-clip-item').forEach(function (el) {
        el.addEventListener('mouseenter', function () {
            try {
                this.querySelector('video').play();
                this.querySelector('i').style.display = 'none';
            } catch {
            }

        });
        el.addEventListener('mouseleave', function () {
            try {
                this.querySelector('video').pause();
                this.querySelector('i').style.display = 'block';
            } catch {
            }
        });
    });
});
