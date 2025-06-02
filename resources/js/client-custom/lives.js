window.addEventListener('load', function () {
    document.querySelectorAll('.live-card-show')?.forEach(function (el) {
        el.addEventListener('click', async function (e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');
            let response = await axios.get(url);
            document.querySelector('#live-card-list').innerHTML = response.data;
            document.querySelector('#live-card-modal').style.display = 'block';
        });
    });

    document.querySelector('#live-card-modal').addEventListener('click',function (e) {
        if (e.target == this){
            document.querySelector('#live-card-modal').style.display = 'none';
        }
    });
})
