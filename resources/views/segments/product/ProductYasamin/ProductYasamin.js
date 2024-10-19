import Lightbox from "bs5-lightbox";
import {tns} from "tiny-slider";

var  YacRelativeSlider;
document.addEventListener('DOMContentLoaded',function () {
    for (const el of document.querySelectorAll('.light-box')) {
        el.addEventListener('click', Lightbox.initialize);
    }

    try {
        YacRelativeSlider = tns({
            container: '#rel-products',
            items: 3,
            autoplay: true,
            autoplayButton: false,
            // nextButton: false,
            controls: false,
            autoplayHoverPause: true,
            mouseDrag: true,
            gutter: 5,
            slideBy: 1,
            autoplayTimeout: 5000,
            responsive:{
                560:{
                    items: 1,
                },
                768:{
                    items: 2,
                },
                1000:{
                    items: 4,
                },
                1400:{
                    items: 5,
                },

            }
            // speed:10000,
        });
    } catch {
    }

});
