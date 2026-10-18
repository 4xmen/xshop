import {tns} from "tiny-slider/src/tiny-slider";

var downtownSlider;

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#downtown-slider')?.forEach(function (el) {
        if (el.classList.contains('.tns-slider')) {
            console.log('ignore');
            return 'ignore';
        }
        downtownSlider = tns({
            container: el,
            items: 1,
            // slideBy: 'page',
            autoplay: true,
            autoplayButton: false,
            // nextButton: false,
            controls: false,
            autoplayHoverPause: false,
            mouseDrag: true,
            autoplayTimeout: 5000,
            autoplayButtonOutput: false,

            // speed:10000,

        });
        el.addEventListener('mouseenter', () => {
            downtownSlider.pause();
        });

        el.addEventListener('mouseleave', () => {
            downtownSlider.play();
        });
    });
});


