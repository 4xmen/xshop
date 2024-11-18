import {tns} from "tiny-slider/src/tiny-slider";

var samSlider ;


document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#samira-slider')?.forEach(function (el) {
        if (el.classList.contains('.tns-slider')){
            console.log('ignore');
            return 'ignore';
        }
        samSlider = tns({
            container: el,
            items: 1.5,
            // edgePadding: 50,
            autoplay: true,
            autoplayButton: false,
            mouseDrag: true,
            prevButton: false,
            nextButton: false,
            autoplayTimeout: 8000,
            center: true,
            nav: true,
            loop:true,
        });
    });

    document.querySelector('#sam-nxt')?.addEventListener('click',function () {
        if (document.documentElement.getAttribute('dir') === 'rtl'){
            samSlider.goTo('prev');
        }else{
            samSlider.goTo('next');
        }
    });
    document.querySelector('#sam-prv')?.addEventListener('click',function () {
        if (document.documentElement.getAttribute('dir') !== 'rtl'){
            samSlider.goTo('prev');
        }else{
            samSlider.goTo('next');
        }
    });
});
