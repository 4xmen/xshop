let now = 100;
let preloading ;
const preloader = document.querySelector('#LinePreloader');
document.addEventListener('DOMContentLoaded', () => {
   preloading = setInterval(() => {
       now -= now / 90;
       preloader.style.width =  (100 -  now)+'%';
   },25);
});
window.addEventListener('load', function () {
    clearInterval(preloading);
    preloader.style.width =  '100%';
    preloader.style.transition = '500ms'
    setTimeout(()=>{
        preloader.style.opacity = '0';
    },1000)
})

