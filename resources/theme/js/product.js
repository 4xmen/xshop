$(function () {
    $('.chose-color label').click(function () {
        $('.chose-color label').removeClass('active')
        $(this).addClass('active')
    })

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }


    $('form #count').on('change', function () {
        let count = $(this).val();
        currentPrice = 14450000;
        showPrice = count * currentPrice;
        $('.price').text(numberWithCommas(showPrice) + 'تومان')
    })

    $.fn.numberstyle = function (options) {

        /*
         * Default settings
         */
        var settings = $.extend({
            value: 0,
            step: undefined,
            min: undefined,
            max: undefined
        }, options);

        /*
         * Init every element
         */
        return this.each(function (i) {

            /*
             * Base options
             */
            var input = $(this);

            /*
       * Add new DOM
       */
            var container = document.createElement('div'),
                btnAdd = document.createElement('div'),
                btnRem = document.createElement('div'),
                min = (settings.min) ? settings.min : input.attr('min'),
                max = (settings.max) ? settings.max : input.attr('max'),
                value = (settings.value) ? settings.value : parseFloat(input.val());
            container.className = 'numberstyle-qty';
            btnAdd.className = (max && value >= max) ? 'qty-btn qty-add disabled' : 'qty-btn qty-add';
            btnAdd.innerHTML = '+';
            btnRem.className = (min && value <= min) ? 'qty-btn qty-rem disabled' : 'qty-btn qty-rem';
            btnRem.innerHTML = '-';
            input.wrap(container);
            input.closest('.numberstyle-qty').prepend(btnRem).append(btnAdd);

            /*
             * Attach events
             */
            // use .off() to prevent triggering twice
            $(document).off('click', '.qty-btn').on('click', '.qty-btn', function (e) {

                var input = $(this).siblings('input'),
                    sibBtn = $(this).siblings('.qty-btn'),
                    step = (settings.step) ? parseFloat(settings.step) : parseFloat(input.attr('step')),
                    min = (settings.min) ? settings.min : (input.attr('min')) ? input.attr('min') : undefined,
                    max = (settings.max) ? settings.max : (input.attr('max')) ? input.attr('max') : undefined,
                    oldValue = parseFloat(input.val()),
                    newVal;

                //Add value
                if ($(this).hasClass('qty-add')) {

                    newVal = (oldValue >= max) ? oldValue : oldValue + step,
                        newVal = (newVal > max) ? max : newVal;

                    if (newVal == max) {
                        $(this).addClass('disabled');
                    }
                    sibBtn.removeClass('disabled');

                    //Remove value
                } else {

                    newVal = (oldValue <= min) ? oldValue : oldValue - step,
                        newVal = (newVal < min) ? min : newVal;

                    if (newVal == min) {
                        $(this).addClass('disabled');
                    }
                    sibBtn.removeClass('disabled');

                }

                //Update value
                input.val(newVal).trigger('change');

            });

            input.on('change', function () {

                const val = parseFloat(input.val()),
                    min = (settings.min) ? settings.min : (input.attr('min')) ? input.attr('min') : undefined,
                    max = (settings.max) ? settings.max : (input.attr('max')) ? input.attr('max') : undefined;

                if (val > max) {
                    input.val(max);
                }

                if (val < min) {
                    input.val(min);
                }
            });

        });
    };


    $("#main-img .xzoom, .xzoom-gallery").xzoom({
        tint: '#333',
        Xoffset: 50,
        zoomWidth: 50,
        zoomHeight: 50,
        position: 'inside'
    });


    $('#main-img .xzoom-thumbs .owl-carousel').owlCarousel({
        rtl: true,
        loop: false,
        margin: 10,
        dots: false,
        responsive: {
            0: {
                items: 4,
                nav: false,

            },
            600: {
                items: 4,
                nav: false,

            },
            1000: {
                items: 4,
                nav: true,

            }
        },

    })

    $('#main-img .owl-carousel .item a').click(function (e) {
        e.preventDefault()

    })
    /*
     * Init
     */

    $('.numberstyle').numberstyle();
})

//    mobile navigation
// $('#mobile').hcOffcanvasNav({
//     disableAt: 1024,
//     customToggle: $('#nav-icon'),
//     navTitle: 'All Categories',
//     levelTitles: true,
//     levelTitleAsBack: true,
//     position: 'right',
//     rtl: true,
//     levelOpen: 'expand',
// });

//Scroll back to top
