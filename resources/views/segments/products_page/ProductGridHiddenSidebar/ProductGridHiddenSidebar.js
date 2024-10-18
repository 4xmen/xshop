document.addEventListener('DOMContentLoaded',function () {
    document.querySelector('#filter-btn-show')?.addEventListener('click',function () {
      document.querySelector('#hidden-sidebar').style.display = 'block';
    });
    document.querySelector('#hidden-sidebar')?.addEventListener('click',function (e) {
        if (e.target  == document.querySelector('#hidden-sidebar') ) {
            document.querySelector('#hidden-sidebar').style.display = 'none';
        }
    });
});
