import {tns} from "tiny-slider/src/tiny-slider";

var sliderSimple ;

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.SliderSimple')?.forEach(function (el) {
        if (el.classList.contains('.tns-slider')){
            console.log('ignore');
            return 'ignore';
        }
        sliderSimple = tns({
            container: el,
            items: 1,
            slideBy: 'page',
            autoplay: true,
            autoplayButton: false,
            // nextButton: false,
            controls: false,
            autoplayHoverPause: true,
            mouseDrag: true,
            // speed:10000,
        });
    });
});
