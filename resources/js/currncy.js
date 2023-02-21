// by a1gard for commafy input price


function nocomma(num) {
    a = num.replace(/\,/g, ''); // 1125, but a string, so convert it to number
    return a.toString();
}

function commafy(num) {
    num = nocomma(num);
    var str = num.toString().split('.');
    if (str[0].length >= 4) {

        str[0] = str[0].replace(/(\d)(?=(\d{3})+$)/g, '$1,');
    }
    if (str[1] && str[1].length >= 4) {

        str[1] = str[1].replace(/(\d{3})/g, '$1,');
    }
    return str.join('.');
}


(function ($) {
    $(function () {

        // handle commafy when edit or focus
        $(".currency").bind('focus keyup', function () {
            $(this).val(commafy($(this).val()));
        });
        // remove comma for form submit ;)
        $(".currency").bind('blur', function () {
            $(this).val(nocomma($(this).val()));
        });

    });
})(jQuery);
