import axios from "axios";

function isValidMobile(p) {
    const regex = /^(\+|[0-9])([0-9]{9,14})$/gm;
    return regex.test(p);
}


document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('#send-auth-code')?.addEventListener('click', async function () {
        try {
            let url = this.getAttribute('data-route');
            let tel = document.querySelector('#tel').value;
            if (tel.length < 11 || !isValidMobile(tel)) {
                window.$toast.error('Invalid mobile');
                return;
            }

            let resp = await axios.get(url + '?tel=' + tel);
            if (resp.data.OK) {
                window.$toast.success(resp.data.message);
                document.querySelector('#tel').setAttribute('readonly', '');
                document.querySelector('.not-send').style.display = 'block';
                document.querySelector('.sent').style.display = 'none';
            } else {
                window.$toast.error(resp.data.message);
            }
        } catch (e) {
            window.$toast.error(e.message);
        }

    });
    document.querySelector('#send-auth-check')?.addEventListener('click', async function () {
        try {


            let url = this.getAttribute('data-route');
            let tel = document.querySelector('#tel').value;
            let code = document.querySelector('#auth').value;
            if (tel.length < 11 || !isValidMobile(tel)) {
                window.$toast.error('Invalid mobile');
                return;
            }
            if (code.length != 5) {
                window.$toast.error('Invalid code');
                return;
            }

            let resp = await axios.get(url + '?tel=' + tel + '&code=' + code);
            if (resp.data.OK) {
                window.$toast.success(resp.data.message);
                setTimeout(() => {
                    window.location.href = this.getAttribute('data-profile');
                }, 5000);
            } else {
                window.$toast.error(resp.data.message);
            }
        } catch (e) {
            window.$toast.error(e.message);

        }
    });
});
