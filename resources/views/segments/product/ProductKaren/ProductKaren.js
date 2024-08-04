import Lightbox from 'bs5-lightbox' ;
import {tns} from "tiny-slider/src/tiny-slider";

var karenImgSlider, karenRelativeSlider;
document.addEventListener('DOMContentLoaded',function () {

    for (const el of document.querySelectorAll('.light-box')) {
        el.addEventListener('click', Lightbox.initialize);
    }
    try {
        karenImgSlider = tns({
            container: '#karen-img-slider',
            items: 3,
            autoplay: true,
            autoplayButton: false,
            // nextButton: false,
            controls: false,
            autoplayHoverPause: true,
            mouseDrag: true,
            gutter: 5,
            slideBy: 1,
            autoplayTimeout: 5000,
            // speed:10000,
        });
        karenRelativeSlider = tns({
            container: '#rel-products',
            items: 3,
            autoplay: true,
            autoplayButton: false,
            // nextButton: false,
            controls: false,
            autoplayHoverPause: true,
            mouseDrag: true,
            gutter: 5,
            slideBy: 1,
            autoplayTimeout: 5000,
            responsive:{
                560:{
                    items: 1,
                },
                768:{
                    items: 2,
                },
                1000:{
                    items: 4,
                },
                1400:{
                    items: 5,
                },

            }
            // speed:10000,
        });
    } catch {
    }


    document.querySelectorAll('#karen-img-slider a')?.forEach(function (el) {
        el.addEventListener('click',function (e) {
            e.preventDefault();
            document.querySelector('#karen-main-img').setAttribute('href',el.getAttribute('href'));
            document.querySelector('#karen-main-img img').setAttribute('src',el.querySelector('img').getAttribute('src'));
        })
    });


    // tabs
    const tabs = document.querySelectorAll('.navtab');
    const contents = document.querySelectorAll('.tab-content');
    const underline = document.querySelector('.underline');

    function updateUnderline() {
        try {
            const activeTab = document.querySelector('.navtab.active');
            underline.style.width = `${activeTab.offsetWidth}px`;
            underline.style.left = `${activeTab.offsetLeft}px`;
        } catch {
        }

    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            const target = tab.getAttribute('data-target');
            contents.forEach(content => {
                if (content.id === target) {
                    content.classList.add('active');
                } else {
                    content.classList.remove('active');
                }
            });
            updateUnderline();
        });
    });

    window.addEventListener('resize', updateUnderline);
    updateUnderline();

});
