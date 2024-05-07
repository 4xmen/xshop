window.addEventListener('load', function () {
    try {

        document.querySelectorAll('#panel-navbar a')?.forEach(function (el) {
            el.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href[0] === '#'){
                    e.preventDefault();
                    document.querySelector('#panel').classList.add('sided');
                    document.querySelector('#sidebar-panel').innerHTML = document.querySelector(href).outerHTML;
                }
            });
        })
    } catch (e) {
        console.log(e.message);
    }

});
