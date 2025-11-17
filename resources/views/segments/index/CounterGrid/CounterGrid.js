// Global variables to manage counter animation
var intervals = [];
var counters = [];
var steps = [];
var isCounterInited = false;

// check if element is in viewport
function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
        rect.bottom > 0 &&
        rect.right > 0 &&
        rect.top < (window.innerHeight || document.documentElement.clientHeight) &&
        rect.left < (window.innerWidth || document.documentElement.clientWidth)
    );
}

// remove commas from number string
function uncommafy(txt) {
    return txt.split(',').join('');
}

// add commas to number for better readability
function commafy(num) {
    if (typeof num !== 'string') {
        num = num.toString();
    }
    let str = uncommafy(num.toString()).split('.');
    if (str[0].length >= 4) {
        str[0] = str[0].replace(/(\d)(?=(\d{3})+$)/g, '$1,');
    }
    if (str[1] && str[1].length >= 4) {
        str[1] = str[1].replace(/(\d{3})/g, '$1 ');
    }
    return str.join('.');
}

// improved counter scroll handler
const handleScroll = function() {
    const container = document.getElementById('CounterGrid');
    if (container == null) return;

    if (isElementInViewport(container) && !isCounterInited) {
        isCounterInited = true;

        document.querySelectorAll('.grid-counter').forEach(function (el, key) {
            let max = parseInt(el.getAttribute('data-max'));
            let min = parseInt(el.getAttribute('data-min')) || 0;
            let diff = max - min;

            // calculate more dynamic and smooth step
            let duration = 7000; // total animation duration in ms
            let fps = 60; // frames per second
            let totalFrames = duration / (1000 / fps);

            counters[key] = min;
            steps[key] = diff / totalFrames;

            let tmp = setInterval(() => {
                // increment counter smoothly
                counters[key] += steps[key];

                // stop if reached or exceeded max
                if (counters[key] >= max) {
                    counters[key] = max;
                    clearInterval(tmp);
                }

                // update display
                el.innerHTML = commafy(Math.round(counters[key]));
            }, 1000 / fps);

            intervals.push(tmp);
        });
    }
};

// event listeners for scroll and touch
document.addEventListener('DOMContentLoaded', function () {
    window.addEventListener('scroll', handleScroll);
    window.addEventListener('touchmove', handleScroll);
});
