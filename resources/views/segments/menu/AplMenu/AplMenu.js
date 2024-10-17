const toggleSideMenu = function (e) {
    e.preventDefault();
    let txt = '<ul>';
    document.querySelectorAll('#AplMenu > ul > li')?.forEach(function (el) {
        if(!el.classList.contains('icon-menu')){
            txt += el.outerHTML;
        }
    });
    txt += '</ul>';
    document.querySelector('#reps-menu').innerHTML = txt;
};
document.addEventListener('DOMContentLoaded',function () {
    document.querySelector('#toggler-menu')?.addEventListener('click',toggleSideMenu);
});
