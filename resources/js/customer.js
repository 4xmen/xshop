var data = require('./plugins/data');
var isSendSms = false;

function nocomma(num) {
    a = num.toString().replace(/\,/g, ''); // 1125, but a string, so convert it to number
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

function findNextTabStop(el) {
    var universe = document.querySelectorAll('input, button, select, textarea, a[href]');
    var list = Array.prototype.filter.call(universe, function (item) {
        return item.tabIndex >= "0"
    });
    var index = list.indexOf(el);
    return list[index + 1] || list[0];
}

function findPervTabStop(el) {
    var universe = document.querySelectorAll('input, button, select, textarea, a[href]');
    var list = Array.prototype.filter.call(universe, function (item) {
        return item.tabIndex >= "0"
    });
    var index = list.indexOf(el);
    return list[index - 1] || list[0];
}

jQuery(function ($) {

    $('.sms-pass').bind('focus', function () {
        this.setSelectionRange(0, this.value.length);
    });
    $('.sms-pass').bind('keyup', function () {
        if ($(this).val().length == 1) {
            let x = findNextTabStop(this);
            x.focus();
        } else if ($(this).val().length == 0) {
            let x = findPervTabStop(this);
            x.focus();
        }
    });
    if ($("#state").length != 0) {

        var tx = '<option value=""></option>';
        for (const s of data().states) {
            tx += `<option value="${s.id}">${s.name}</option>`;
        }
        $("#state").append(tx);
        $("#state").val($("#state").data('val'));

        $("#state").change(function () {
            var v = $(this).val();
            var tx = '';
            for (const city of data().cities) {
                if (city.state_id == v) {
                    tx += `<option value="${city.id}">${city.name}</option>`;
                }
            }
            $("#city").html(tx);
        });
        $("#state").change();
        $("#city").val($("#city").data('val'));

    }

    if ($("#state_").length != 0) {

        var tx = '<option value=""></option>';
        for (const s of data().states) {
            tx += `<option value="${s.id}">${s.name}</option>`;
        }
        $("#state_").append(tx);
        $("#state_").val($("#state_").data('val'));

        $("#state_").change(function () {
            var v = $(this).val();
            var tx = '';
            for (const city of data().cities) {
                if (city.state_id == v) {
                    tx += `<option value="${city.id}">${city.name}</option>`;
                }
            }
            $("#city_").html(tx);
        });
        $("#state_").change();
        $("#city_").val($("#city_").data('val'));

    }


    $("#sms-btn").bind('click', function () {
        if ($("#mobile").val().length !== 11) {
            window.alertify.error(window.translate.errMobile);
            return;
        }
        $("#sms-btn").attr('disabled', true);
        if (!isSendSms) {
            axios.post($(this).data('send'), {mobile: $("#mobile").val()}).then(function (e) {
                if (e.data.OK == true) {
                    window.alertify.success(e.data.msg);
                    $("#sms-code").slideDown(500);
                    $("#sms-first").focus();
                    isSendSms = true;
                }
                $("#sms-btn").removeAttr('disabled');
            }).catch(function () {
                window.alertify.error('Server Error');
                $("#sms-btn").removeAttr('disabled');
            });
        } else {
            let pass = '';
            $(".sms-pass").each(function () {
                pass += $(this).val();
            });
            let login = $(this).data('customer');
            axios.post($(this).data('check'), {mobile: $("#mobile").val(), pass: pass}).then(function (e) {
                $("#sms-btn").removeAttr('disabled');
                if (e.data.OK == true) {
                    window.alertify.success(e.data.msg);
                    setTimeout(function () {
                        window.location.href = login;
                    }, 2000);
                } else {
                    window.alertify.error(e.data.err);
                }
            }).catch(function () {
                $("#sms-btn").removeAttr('disabled');
                window.alertify.error('Server Error');
            });
        }
    });

    $(".count-dec").bind('click', function () {
        let inp = $(this).parent().find('input');
        if (parseInt($(inp).val()) - 1 < 1) {
            $(inp).val(1);
        } else {
            $(inp).val(parseInt($(inp).val()) - 1);
        }
        $(inp).change();
    });
    $(".count-inc").bind('click', function () {
        let inp = $(this).parent().find('input');
        if (parseInt($(inp).val()) + 1 > $(inp).attr('max')) {
            $(inp).val($(inp).attr('max'));
        } else {
            $(inp).val(parseInt($(inp).val()) + 1);
        }
        $(inp).change();
    });

    $(".quantity").bind('click', function () {
        $(this).closest('td').find('.quantity').removeClass('active');
        $(this).closest('td').find('.quantity input').removeAttr('checked');
        $(this).addClass('active');
        $(this).find('input')[0].checked = true;
        $(this).closest('tr').find('.price-td').attr('data-price', $(this).data('price'));
        $(this).closest('tr').find('.price').text(commafy($(this).data('price')));
        $(this).closest('tr').find('.product-count input').attr('max', $(this).data('count'));
        if ($(this).data('count') == 0) {
            $(this).closest('tr').find('.product-count input').attr('max', 0);
        }
        updateCard();
    });

    $('.product-count input').bind('change', function () {
        updateCard()
    });

    function updateCard() {
        let totalPrice = 0;
        for (const td of document.querySelectorAll('.price-td')) {
            let price = parseInt($(td).attr('data-price'));
            let count = parseInt($(td).closest('tr').find('.product-count input').val());
            $(td).closest('tr').find('.product-count input').attr('max', $(td).closest('tr').find('.active').data('count'));

            // maybe need comment
            if ($(td).closest('tr').find('.product-count input').attr('max') == '0'){
                $(td).closest('tr').find('.product-count input').attr('max',1)
            }
            totalPrice += price * count;
        }


        // check price
        try {
            let discount = JSON.parse($("#discount").attr('data-discount'));
            if (!isNaN(parseInt(discount.amount))) {
                if (discount.type === 'price') {
                    totalPrice -= parseInt(discount.amount);
                } else {
                    totalPrice -= ((100 - parseInt(discount.amount)) * totalPrice) / 100;
                }
            }
        } catch (e) {
            // console.log(e.message);
        }
        let lastprice = totalPrice;
        if ($(".transport:checked").data('price') !== undefined) {
            lastprice += parseInt($(".transport:checked").data('price'));
        }
        // transport
        $('#total-card').text(commafy(totalPrice));
        $('#last-price').text(commafy(lastprice));

    }

    $(".reserve").change(function () {
        if ($(".reserve:checked").length > 0){
            $(".transport").removeAttr('checked');
        }
        $("#resv").hide();
        $("#flexSwitchCheckDefault").removeAttr('checked');
        updateCard();
    });
    $(".transport").change(function () {
        if ($(".transport:checked").length > 0){
            $(".reserve").removeAttr('checked');
        }
        $("#resv").show();
        updateCard();
    });
    // discount
    $("#discount").bind('click', function () {
        axios.post($(this).data('url'), {code: $("#discount-code").val()}).then(function (e) {
            $("#discount").attr('data-discount', JSON.stringify(e.data));
            window.alertify.success(window.translate.discountCodeAccept);
            updateCard();
        }).catch(function () {
            $("#discount").attr('data-discount', '{}');
            window.alertify.error(window.translate.discountCodeError);
            updateCard();
        });
    });

    $("#profile-tab li").bind('click', function () {
        $("#profile-tab li").removeClass('active');
        $(this).addClass('active');
        $(".profile-tab.active").slideUp(300, function () {
            $(this).removeClass('active');
        });
        $($(this).data('id')).slideDown(300, function () {
            $(this).addClass('active');
        })
    });

    updateCard();

    setTimeout(function () {
        if ($("#catId").length > 0) {
            let url = $("#catId").data('url');
            $.get(url, function (e) {
                // console.log(app);
                app.jdata = e[1];
            });
        }
    }, 500);



    $(".next-step").bind('click', function () {
        step++;
        $(".step" + step).click();
    });

    $(".progress-step .step").click(function () {
        $(".progress-step .step").removeClass('done');
        $($(this).data('done')).addClass('done');
        $("#card-steps .active-step").slideUp(300).removeClass('active-step');
        $('#' + $(this).data('id')).slideDown(500).addClass('active-step');
        step = parseInt($(this).data('id').substr(4, 1));
        if ($(this).data('id') == 'step3') {
            $(".last-step").slideDown(300);
            $(".next-step").slideUp(300);
        } else {
            $(".last-step").slideUp(300);
            $(".next-step").slideDown(300);
        }
    });
});


