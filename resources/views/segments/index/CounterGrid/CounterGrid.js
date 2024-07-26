var intervals = [];
var counters = [];
var steps = [];
var isCounterInited = false;

function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

function uncommafy(txt) {
    return txt.split(',').join('');
}

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

document.addEventListener('DOMContentLoaded', function () {

    window.addEventListener('scroll', function() {
        const container = document.getElementById('CounterGrid');
        if (container == null){
            return ;
        }
        if (isElementInViewport(container)) {
            if (!isCounterInited){
                isCounterInited = true;
                document.querySelectorAll('.grid-counter').forEach(function (el, key) {

                    let max = parseInt(el.getAttribute('data-max'));
                    let min = parseInt(el.getAttribute('data-min'));
                    let diff = max - min;
                    counters[key] = 0;
                    steps[key] = parseInt(diff / 99);

                    let tmp = setInterval(() => {
                        counters[key] += steps[key];
                        document.querySelectorAll('.grid-counter')[key].innerHTML = commafy(counters[key]);
                    }, 100);
                    setTimeout(function () {
                        for (const i in intervals) {
                            clearInterval(intervals[i]);
                            document.querySelectorAll('.grid-counter')[key].innerHTML = commafy(document.querySelectorAll('.grid-counter')[key].getAttribute('data-max'));
                        }

                    }, 9900);
                    intervals.push(tmp);
                });
            }
            // Remove event listener if you only want to alert once
            // this.removeEventListener('scroll', arguments.callee);
        }
    });


});
