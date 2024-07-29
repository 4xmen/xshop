import Lightbox from 'bs5-lightbox' ;

document.addEventListener('DOMContentLoaded',function () {


    for (const el of document.querySelectorAll('.light-box')) {
        el.addEventListener('click', Lightbox.initialize);
    }

});
