import {tns} from "tiny-slider/src/tiny-slider";

var author ;

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#author-slider')?.forEach(function (el) {
        if (el.classList.contains('.tns-slider')){
            console.log('ignore');
            return 'ignore';
        }
        author = tns({
            container: el,
            autoplay: true,
            autoplayButton: false,
            // nextButton: false,
            controls: false,
            mouseDrag: true,
            autoplayTimeout: 8000,
            gutter: 10,
            items: 1,
            // speed:10000,
        });
    });

    document.querySelector('#auth-nxt')?.addEventListener('click',function () {
        if (document.documentElement.getAttribute('dir') === 'rtl'){
            author.goTo('prev');
        }else{
            author.goTo('next');
        }
    });
    document.querySelector('#auth-prv')?.addEventListener('click',function () {
        if (document.documentElement.getAttribute('dir') !== 'rtl'){
            author.goTo('prev');
        }else{
            author.goTo('next');
        }
    });
});
