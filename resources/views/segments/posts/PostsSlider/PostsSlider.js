import {tns} from "tiny-slider/src/tiny-slider";

var postsSlider ;

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#posts-slider')?.forEach(function (el) {
        if (el.classList.contains('.tns-slider')){
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
            responsive:{
                560:{
                    items: 2,
                    edgePadding: 30,
                },
                768:{
                    items: 4,
                    edgePadding: 40,
                },
                1000:{
                    items: 5,
                    edgePadding: 50,
                },
                1400:{
                    items: 6,
                    edgePadding: 60,
                },

            },
            // speed:10000,
        });
    });

});
