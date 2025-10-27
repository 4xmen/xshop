import {tns} from "tiny-slider/src/tiny-slider";

var randomSlider;

document.addEventListener('DOMContentLoaded', () => {
    try {
        if (document.querySelectorAll('.random-slider').length != 0) {

            document.querySelectorAll('.random-slider')?.forEach(function (el) {
                if (el.classList.contains('.tns-slider')) {
                    console.log('ignore');
                    return 'ignore';
                }
                randomSlider = tns({
                    container: el,
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

                    },
                    autoplay: true,
                    autoplayButton: false,
                    // nextButton: false,
                    controls: false,
                    autoplayHoverPause: true,
                    mouseDrag: true,
                    slideBy: 1,
                    autoplayTimeout: 5000,
                    gutter: 7,
                    // speed:10000,
                });
            });
        }

    } catch {
    }


});
