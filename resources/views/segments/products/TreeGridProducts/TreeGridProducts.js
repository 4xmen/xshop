import {tns} from "tiny-slider/src/tiny-slider";

var treeSlider,treeSliderX, treeSliderY ;

document.addEventListener('DOMContentLoaded', () => {
    console.log('3 slider');
    document.querySelectorAll('.tree-grid .section-main')?.forEach(function (el) {
        if (el.classList.contains('.tns-slider')){
            console.log('ignore');
            return 'ignore';
        }
        treeSlider = tns({
            container: el,
            items: 3,
            slideBy: 'page',
            autoplay: true,
            autoplayButton: false,
            // nextButton: false,
            controls: false,
            autoplayHoverPause: true,
            mouseDrag: true,
            gutter: 7,
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

            }
            // speed:10000,
        });
    });
    document.querySelectorAll('.tree-grid .section-second')?.forEach(function (el) {
        if (el.classList.contains('.tns-slider')){
            console.log('ignore');
            return 'ignore';
        }
        treeSliderX = tns({
            container: el,
            items: 1,
            slideBy: 'page',
            autoplay: true,
            autoplayButton: false,
            // nextButton: false,
            controls: false,
            autoplayHoverPause: true,
            autoplayTimeout: 8000,
            mouseDrag: true,
            gutter: 7,
            edgePadding: 60,
            // speed:10000,
        });
    });
    document.querySelectorAll('.tree-grid .section-third')?.forEach(function (el) {
        if (el.classList.contains('.tns-slider')){
            console.log('ignore');
            return 'ignore';
        }
        treeSliderX = tns({
            container: el,
            items: 1,
            slideBy: 'page',
            autoplay: true,
            autoplayTimeout: 7500,
            autoplayButton: false,
            // nextButton: false,
            controls: false,
            autoplayHoverPause: true,
            mouseDrag: true,
            gutter: 7,
            edgePadding: 60,
            // speed:10000,
        });
    });
});
