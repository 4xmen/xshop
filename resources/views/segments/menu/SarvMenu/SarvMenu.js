window.addEventListener('load', function () {
    try {
        window.addEventListener('scroll', function (e) {
            try {
                if (window.scrollY > 100) {
                    document.querySelector('.SarvMenu').classList.add('fixed');
                } else {
                    document.querySelector('.SarvMenu').classList.remove('fixed');
                }
            } catch {
            }

        });

        document.querySelector('#sarv-toggle').addEventListener('click', function () {
            document.querySelector('#sarv-responsive-menu').style.display = 'flex';
        });

        document.querySelector('#sarv-responsive-menu').addEventListener('click', function (e) {
            if (e.target == this) {
                document.querySelector('#sarv-responsive-menu').style.display = 'none';
            }
        });
    } catch (e) {
    }

})
