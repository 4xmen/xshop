window.addEventListener('load', function () {
    const favUrl = document.querySelector('#api-fav-toggle').value;
    document.querySelectorAll('.fav-btn')?.forEach(function (el) {
        el.addEventListener('click', async function () {
            let resp = await axios.get(favUrl+this.getAttribute('data-slug'));
            if (resp.data.success){
                this.setAttribute('data-is-fav',resp.data.data);
                window.$toast.success(resp.data.message);
            }
        });
    });
});
