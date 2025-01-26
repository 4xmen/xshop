document.addEventListener('DOMContentLoaded',function () {
    document.querySelectorAll('.pedi-tab-control li')?.forEach(function (el) {
        el.addEventListener('click',function () {
            el.closest('.content').querySelectorAll('.pedi-tab').forEach(function (el2) {
                el2.style.display = 'none';
            });
            el.closest('.content').querySelectorAll('.pedi-tab-control li').forEach(function (el2) {
                el2.classList.remove('active');
            });
            el.classList.add('active');
            el.closest('.content')
                .querySelector(el.getAttribute('data-id'))
                .style.display = 'block';
        });
    })
});
