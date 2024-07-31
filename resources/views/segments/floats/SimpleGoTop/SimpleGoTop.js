const scrollBreakpoint = window.innerHeight * 0.2;
window.addEventListener('scroll',function () {
    if (window.scrollY > scrollBreakpoint){
        document.querySelector('#SimpleGoTop').classList.add('show')
    }else{
        document.querySelector('#SimpleGoTop').classList.remove('show')
    }
});
