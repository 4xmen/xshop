/**
 * trim char
 * @param s String
 * @param c char
 * @returns {*}
 */
function trimer (s, c) {
    if (c === "]") c = "\\]";
    if (c === "^") c = "\\^";
    if (c === "\\") c = "\\\\";
    return s.replace(new RegExp(
        "^[" + c + "]+|[" + c + "]+$", "g"
    ), "");
}
document.addEventListener('DOMContentLoaded',function () {

    // make current page
    document.querySelectorAll('#SideMenu li').forEach(function (el) {
        if (trimer(el.querySelector('a').getAttribute('href'),'/') == trimer( window.location.href,'/')){
            el.classList.add('current-page');
        }
    });
    if (document.querySelectorAll('#SideMenu li.current-page').length == 0){
        document.querySelector('#SideMenu li:first-child').classList.add('current-page');
    }

    // toggle menu for reposive
    document.querySelector('#side-menu-btn').addEventListener('click',function () {
       this.closest('nav').querySelector('ul').classList.toggle('active');
    });
});
