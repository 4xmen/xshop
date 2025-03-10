document.addEventListener('DOMContentLoaded',function () {
    document.querySelector('#rect-toggle')?.addEventListener('click',function (e) {
        e.preventDefault();
        document.querySelector('#RecetMenu').classList.toggle('show-menu');
        setTimeout(function () {
            document.addEventListener('click', handleDocumentClick);
        },100);
    });
})


function handleDocumentClick(e) {
    if (!document.querySelector('#RecetMenu').contains(e.target)) {
        document.querySelector('#RecetMenu').classList.toggle('show-menu');
        document.removeEventListener('click', handleDocumentClick);
    }
}
