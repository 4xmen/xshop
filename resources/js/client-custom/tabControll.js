document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelectorAll('.tab-control a').length > 0) {
        document.querySelectorAll('.tab-control a')?.forEach(function (el) {

            el.addEventListener('click', function () {
                try {
                    document.querySelector('.tab-control a.active').classList.remove('active');
                    this.classList.add('active');
                    document.querySelector('.tab.active,.tab-content.active').classList.remove('active');
                    document.querySelector(this.getAttribute('href')).classList.add('active');
                } catch {
                }

            });
        });
    }

    if(window.location.hash) {
       document.querySelector(`.tab-control [href="${window.location.hash}"]`)?.click();
    }
});
