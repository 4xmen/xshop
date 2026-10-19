import {tns} from "tiny-slider/src/tiny-slider";

var sliderSimple;

document.addEventListener('DOMContentLoaded', () => {
    try {
        if (document.querySelectorAll('.SliderSimple').length != 0) {

            document.querySelectorAll('.SliderSimple')?.forEach(function (el) {
                if (el.classList.contains('.tns-slider')) {
                    console.log('ignore');
                    return 'ignore';
                }
                sliderSimple = tns({
                    container: el,
                    items: 1,
                    autoplay: true,
                    autoplayButton: false,
                    // nextButton: false,
                    controls: false,
                    autoplayHoverPause: false,
                    mouseDrag: true,
                    slideBy: 1,
                    autoplayTimeout: 5000,
                    // speed:10000,
                });

                el.addEventListener('mouseenter', () => {
                    sliderSimple.pause();
                });

                el.addEventListener('mouseleave', () => {
                    sliderSimple.play();
                });
            });

        }

    } catch {
    }


});
