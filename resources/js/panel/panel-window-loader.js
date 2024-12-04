let isWinLoaded = false;
window.addEventListener('load',function () {

    if (!isWinLoaded){
        forceLoad();
        isWinLoaded = true;
    }
});


setTimeout(function () {
    if (!isWinLoaded){
        forceLoad();
        isWinLoaded = true;
    }
},5000);
const forceLoad = function () {
    try {
        const  preloader = document.querySelector('#panel-preloader');
        preloader.style.height = 0;
        setTimeout( () => {
            preloader.style.display = 'none';
        },500);
    } catch {
    }

};
