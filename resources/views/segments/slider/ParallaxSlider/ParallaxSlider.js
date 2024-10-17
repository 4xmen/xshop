import {tns} from "tiny-slider/src/tiny-slider";

var parallaxSlider;

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#ParallaxSliderTns')?.forEach(function (el) {
        if (el.classList.contains('.tns-slider')) {
            console.log('ignore');
            return 'ignore';
        }
        parallaxSlider = tns({
            container: el,
            items: 1,
            // slideBy: 'page',
            autoplay: false,
            autoplayButton: false,
            // nextButton: false,
            controls: false,
            autoplayHoverPause: true,
            mouseDrag: true,
            autoplayTimeout: 5000,
            autoplayButtonOutput: false,

            // speed:10000,

        });
    });

    // document.addEventListener('scroll', function() {
    //     const scrolled = window.scrollY;
    //     const slides = document.querySelectorAll('.parallax-slider');
    //
    //     slides.forEach((slide) => {
    //         const offset = slide.offsetTop;
    //         slide.style.backgroundPositionY = `${(offset - scrolled) * 0.2}px`; // Adjust the multiplier for effect
    //     });
    // });

    // Parallax effect
    function applyParallax() {
        const sliders = document.querySelectorAll('.parallax-slider');
        const windowHeight = window.innerHeight;
        const scrollY = window.scrollY;

        sliders.forEach(slider => {
            const sliderRect = slider.getBoundingClientRect();
            const sliderCenter = sliderRect.top + sliderRect.height / 2;
            const viewportCenter = windowHeight / 2;

            const distanceFromCenter = sliderCenter - viewportCenter;
            let parallaxOffset = distanceFromCenter * -.4; // Adjust this value to control parallax intensity

            if (sliderRect.width < 1000){
                parallaxOffset = distanceFromCenter * -.7; // Adjust this value to control parallax intensity
            }

            const bgImage = slider.getAttribute('data-bg');
            slider.style.backgroundImage = `url('${bgImage}')`;
            slider.style.backgroundPositionY = `calc(50% + ${parallaxOffset}px)`;
        });
    }

    try {

        // Apply parallax on scroll and resize
        window.addEventListener('scroll', applyParallax);
        window.addEventListener('resize', applyParallax);

        // Initial application
        applyParallax();

        // Reapply parallax when tiny-slider changes slides
        parallaxSlider.events.on('transitionEnd', applyParallax);

    } catch {
    }
});
