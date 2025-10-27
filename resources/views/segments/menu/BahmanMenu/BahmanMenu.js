var nested = false;
document.addEventListener('DOMContentLoaded',function () {
    document.querySelector('#bahman-toggle')?.addEventListener('click',function (e) {
        e.preventDefault();
        document.querySelector('#bahman-modal').style.maxHeight = '100vh';
    });
    document.querySelector('#bahman-modal').addEventListener('click',function (e) {
        if (e.target == this){
            this.style.maxHeight = '0';
        }
    })
})


