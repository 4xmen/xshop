document.addEventListener('DOMContentLoaded',function () {
    document.querySelectorAll('.tal-tab-control li')?.forEach(function (el) {
        el.addEventListener('click',function () {
            el.closest('.content').querySelectorAll('.tal-tab').forEach(function (el2) {
              el2.style.display = 'none';
            });
            el.closest('.content').querySelectorAll('.tal-tab-control li').forEach(function (el2) {
              el2.classList.remove('active');
            });
            el.classList.add('active');
            el.closest('.content')
                .querySelector(el.getAttribute('data-id'))
                .style.display = 'block';
        });
    })
});
