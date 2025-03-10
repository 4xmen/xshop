import {tns} from "tiny-slider/src/tiny-slider";

var modrenSlider;

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#ModernSlider')?.forEach(function (el) {
        if (el.classList.contains('.tns-slider')) {
            console.log('ignore');
            return 'ignore';
        }
        modrenSlider = tns({
            container: el,
            items: 1,
            // slideBy: 'page',
            // autoplay: true,
            autoplayButton: false,
            // nextButton: false,
            controls: false,
            autoplayHoverPause: true,
            mouseDrag: true,
            autoplayTimeout: 5000,
            autoplayButtonOutput: false,

            // speed:10000,

        });
    });

});
