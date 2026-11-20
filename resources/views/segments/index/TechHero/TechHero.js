import {tns} from "tiny-slider/src/tiny-slider";

var HeroSliderX;

document.addEventListener('DOMContentLoaded', () => {
    try {
        if (document.querySelectorAll('.SliderHero').length != 0) {

            document.querySelectorAll('.SliderHero')?.forEach(function (el) {
                if (el.classList.contains('.tns-slider')) {
                    console.log('ignore');
                    return 'ignore';
                }
                HeroSliderX = tns({
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
                    HeroSliderX.pause();
                });

                el.addEventListener('mouseleave', () => {
                    HeroSliderX.play();
                });
                const previews = document.querySelectorAll('.prevw-item');

                function setActivePreview(index) {
                    previews.forEach((item, i) => {
                        item.classList.toggle('active', i === index);
                    });
                }

                setActivePreview(HeroSliderX.getInfo().displayIndex - 1);

                HeroSliderX.events.on('indexChanged', (info) => {
                    setActivePreview(info.displayIndex - 1);
                });

            });

        }

    } catch {
    }


});

window.nextHeroSlider = function (id){
    HeroSliderX.goTo(id);
}
