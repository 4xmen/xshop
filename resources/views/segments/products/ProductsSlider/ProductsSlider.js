import {tns} from "tiny-slider/src/tiny-slider";

var productSlider ;
document.addEventListener('DOMContentLoaded',function () {

    document.querySelectorAll('.products-slider')?.forEach(function (el) {
        if (el.classList.contains('.tns-slider')){
            console.log('ignore');
            return 'ignore';
        }
        productSlider = tns({
            container: el,
            autoplay: true,
            autoplayButton: false,
            // nextButton: false,
            controls: false,
            autoplayHoverPause: true,
            mouseDrag: true,
            gutter: 0,
            slideBy: 1,
            autoplayTimeout: 5000,
            responsive:{
                420:{
                    items: 1,
                },
                768:{
                    items:2,
                },
                1000:{
                    items: 3,
                },
                1400:{
                    items: 4,
                },

            }
            // speed:10000,
        });
    });

});
