window.addEventListener('load',function () {
    document.querySelectorAll('#product-list-view nav .pagination .page-link')?.forEach(function (el) {
        el.setAttribute('href',el.getAttribute('href')+'#product-list-view');
    });
});
