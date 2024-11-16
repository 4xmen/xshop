import {tns} from "tiny-slider/src/tiny-slider";

var curveCatSlider ;

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#curve-slider-cat')?.forEach(function (el) {
        if (el.classList.contains('.tns-slider')){
            console.log('ignore');
            return 'ignore';
        }
        curveCatSlider = tns({
            container: el,
            responsive:{
                560:{
                    items: 1.5,
                },
                1000:{
                    items: 3.5,
                },
                1400:{
                    items: 5.5,
                },

            },
            // edgePadding: 50,
            autoplay: true,
            autoplayButton: false,
            mouseDrag: true,
            prevButton: false,
            nextButton: false,
            autoplayTimeout: 8000,
            center: true,
            nav: true,
            loop:true,
        });
    });
    //
    document.querySelector('#crc-nxt')?.addEventListener('click',function () {
        if (document.documentElement.getAttribute('dir') === 'rtl'){
            curveCatSlider.goTo('prev');
        }else{
            curveCatSlider.goTo('next');
        }
    });
    document.querySelector('#crc-prv')?.addEventListener('click',function () {
        if (document.documentElement.getAttribute('dir') !== 'rtl'){
            curveCatSlider.goTo('prev');
        }else{
            curveCatSlider.goTo('next');
        }
    });
});
