const scrollBreakpoint = window.innerHeight * 0.7;
window.addEventListener('scroll',function () {
    if (window.scrollY > scrollBreakpoint){
        document.querySelector('#DeebaMenu').classList.add('active')
    }else{
        document.querySelector('#DeebaMenu').classList.remove('active')
    }
});

window.addEventListener('load',function () {
    document.querySelector('#deeba-toggle')?.addEventListener('click',function () {
        document.querySelector('#deeba-sided').classList.toggle('show');
    });
});
