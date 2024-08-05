document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.autoplay-clip-item').forEach(function (el) {
        el.addEventListener('mouseenter', function () {
            try {
                this.querySelector('video').play();
            } catch {
            }

        });
        el.addEventListener('mouseleave', function () {
            try {
                this.querySelector('video').pause();
            } catch {
            }
        });
    });
});
