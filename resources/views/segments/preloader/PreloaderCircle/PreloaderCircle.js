let isHidePreloader = false;
const hidePreloader= function (){
    if (!isHidePreloader){
        document.querySelector('#website-preloader').style.opacity = 0;
        setTimeout(()=>{
            document.querySelector('#website-preloader').remove();
        },510);
        isHidePreloader = true;
    }
};

window.addEventListener('load',function () {
    hidePreloader();
});

// if field and didn't load after 10s
setTimeout(()=>{
    hidePreloader();
},10000);



