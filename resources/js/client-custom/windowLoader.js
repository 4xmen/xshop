import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.min.js';

window.addEventListener('load', function () {
    const API_COOKIE_NAME = 'last_api_call';
    const COOKIE_EXPIRY_MINUTES = 59;

    function setCookie(name, value, minutes) {
        let expires = "";
        if (minutes) {
            let date = new Date();
            date.setTime(date.getTime() + (minutes * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    function getCookie(name) {
        let nameEQ = name + "=";
        let ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function canSendData() {
        let lastCall = getCookie(API_COOKIE_NAME);
        if (!lastCall) return true;

        let lastCallTime = new Date(parseInt(lastCall));
        let currentTime = new Date();
        let timeDiff = (currentTime - lastCallTime) / (1000 * 60); // difference in minutes

        return timeDiff >= COOKIE_EXPIRY_MINUTES;
    }

    if (canSendData()) {
        axios.post(document.querySelector('#api-display-url').value, {
            display: window.screen.availWidth + 'x' + window.screen.availHeight,
        }).then(function (response) {
            // If the API call is successful, set the cookie
            setCookie(API_COOKIE_NAME, new Date().getTime(), COOKIE_EXPIRY_MINUTES);
        }).catch(function (error) {
            console.error('Error sending data:', error);
        });
    } else {
        console.log('Data was sent recently. Skipping this time.');
    }


    // bootstrap fix start
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    // add table class autho
    document.querySelectorAll('.content table')?.forEach(function (el) {
        el.classList.add('table')
    });

    // bootstrap fix end

});
