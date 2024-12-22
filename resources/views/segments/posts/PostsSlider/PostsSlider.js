import {tns} from "tiny-slider/src/tiny-slider";

var postsSlider;

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#posts-slider')?.forEach(function (el) {
        if (el.classList.contains('.tns-slider')) {
            console.log('ignore');
            return 'ignore';
        }
        postsSlider = tns({
            container: el,
            autoplay: true,
            autoplayButton: false,
            // nextButton: false,
            controls: false,
            mouseDrag: true,
            autoplayTimeout: 5000,
            gutter: 10,
            responsive: {
                560: {
                    items: 2,
                    edgePadding: 30,
                },
                768: {
                    items: 3,
                    edgePadding: 40,
                },
                1000: {
                    items: 4,
                    edgePadding: 50,
                },
                1400: {
                    items: 5,
                    edgePadding: 60,
                },
                1700: {
                    items: 6,
                    edgePadding: 60,
                },

            },
            // speed:10000,
        });
    });

    document.querySelector('#pst-nxt')?.addEventListener('click',function () {
        if (document.documentElement.getAttribute('dir') === 'rtl'){
            postsSlider.goTo('prev');
        }else{
            postsSlider.goTo('next');
        }
    });
    document.querySelector('#pst-prv')?.addEventListener('click',function () {
        if (document.documentElement.getAttribute('dir') !== 'rtl'){
            postsSlider.goTo('prev');
        }else{
            postsSlider.goTo('next');
        }
    });

});
