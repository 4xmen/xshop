document.addEventListener('DOMContentLoaded', function () {

    let attachFrom = document.querySelector('#attaching-form');
    document.querySelector('#attach-down')?.addEventListener('click', function () {
        attachFrom.style.bottom = (window.innerHeight * -.5+'px');
    });
    document.querySelector('#show-attach-form')?.addEventListener('click', function (e) {
        e.preventDefault();
        attachFrom.style.bottom = ('0px');
    });
});
