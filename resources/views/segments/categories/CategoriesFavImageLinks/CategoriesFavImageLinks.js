import {tns} from "tiny-slider/src/tiny-slider";

var brandSlider ;

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#brands-slider')?.forEach(function (el) {
        if (el.classList.contains('.tns-slider')){
            console.log('ignore');
            return 'ignore';
        }
        brandSlider = tns({
            container: el,
            items: 3,
            autoplay: true,
            autoplayButton: false,
            // nextButton: false,
            autoplayHoverPause: true,
            mouseDrag: true,
            gutter: 20,
            slideBy: 1,
            controlsPosition: "bottom",
            navPosition: "bottom",
            controls: false,
            responsive:{
                560:{
                    items: 1,
                },
                768:{
                    items: 2,
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
