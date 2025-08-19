
const hideSidebar = function (e) {
    if (!e.target.closest('aside') && !e.target.closest('#sidebar-panel')) {
        document.querySelector('#panel').classList.remove('sided');
        document.querySelector('main').classList.remove('blured');
        document.removeEventListener('click', hideSidebar);
    }
};
window.addEventListener('load', function () {

    try {

        document.querySelectorAll('#panel-navbar a')?.forEach(function (el) {
            el.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href[0] === '#'){
                    e.preventDefault();
                    document.querySelector('#panel').classList.add('sided');
                    document.querySelector('#sidebar-panel').innerHTML = document.querySelector(href).outerHTML;
                    document.querySelector('main').classList.add('blured');
                    setTimeout(function () {
                        document.addEventListener('click',hideSidebar);
                    },50);
                }
            });
        });


        document.querySelector('#switch-theme')?.addEventListener('click',function () {
            const html = document.querySelector('html');
            const theme = html.getAttribute('data-bs-theme');
            if (theme == 'dark'){
                html.setAttribute('data-bs-theme','light');
            }else{
                html.setAttribute('data-bs-theme','dark');
            }

            axios.get(switchThemeUrl);
        })

    } catch (e) {
        console.log(e.message);
    }

});
