import {tns} from "tiny-slider/src/tiny-slider";

var maincatz;

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#main-cats')?.forEach(function (el) {
        if (el.classList.contains('.tns-slider')) {
            console.log('ignore');
            return 'ignore';
        }
        maincatz = tns({
            container: el,
            items: 3,
            autoplay: true,
            autoplayButton: false,
            // nextButton: false,
            controls: false,
            autoplayHoverPause: true,
            mouseDrag: true,
            gutter: 7,
            slideBy: 1,
            autoplayTimeout: 5000,
            responsive: {
                560: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                1000: {
                    items: 2,
                },
                1400: {
                    items: 3,
                },

            }
            // speed:10000,
        });
    });
});
