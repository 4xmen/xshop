document.addEventListener('DOMContentLoaded',function () {
    document.querySelector('#rect-toggle')?.addEventListener('click',function (e) {
        e.preventDefault();
        document.querySelector('#RecetMenu').classList.toggle('show-menu');
    });
})
