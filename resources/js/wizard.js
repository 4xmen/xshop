jQuery(function () {
    if ($('.wizard-form').length == 0 || isInit) {
        return false;
    }
    $($('.wizard .step')[0]).addClass('active');
    $($('.wizard .wizard-form')[0]).slideDown(1000).addClass('active');
    var forms = $('.wizard .wizard-form');
    var txt = '';
    var nextStr = window.translate.next;
    var prevStr = window.translate.prev;
    var nextBtnClass = 'wizard-next btn btn-primary';
    for (const i in forms) {
        if (isNaN(parseInt(i))) {
            break;
        }
        var j = (parseInt(i) + 1);
        $($('.wizard .wizard-form')[i]).data('formStep', j).addClass('form-step' + j);
        $($('.wizard .step')[i]).data('formStep', j).addClass('form-step' + (j));

        if (j == forms.length) {
            nextStr = `<span>` + window.translate.finishAndSave + `</span><i class="fas fa-spinner fa-spin"></i>`;
            nextBtnClass = 'wizard-finish btn btn-success';
            tag = 'button';
        } else {
            tag = 'div'
        }

        txt = `<div class="ml-2 mt-4">
            <div class="wizard-prev btn btn-secondary" data-step="${j}">${prevStr}</div>
            <${tag} class="${nextBtnClass}" data-step="${j}" ${tag === 'button' ? 'type="submit"' : ''}>${nextStr}</${tag}>
        </div>`;

        $($('.wizard .wizard-form')[i]).append(txt);
    }

    $(document).on('click', '.wizard .step', function () {
        var step = $(this).data('formStep');
        $('.wizard .wizard-form.active').slideUp(300).removeClass('active');
        var percent = (100 * step / $('.wizard .step').length);
        if (percent != 100) {
            percent -= 10 + (6 - $('.wizard .step').length) + ($('.wizard .step').length - step) + ($('.wizard .step').length < 4 ? 1 : -1);
        }
        $(this).closest('.wizard').find('.prog').css('width', percent + '%');
        setTimeout(function () {
            $(`.wizard .wizard-form.form-step${step}`).slideDown(300, function () {
                $(window).resize();
            }).addClass('active');

            $(`.wizard .step`).removeClass('active');
            for (let i = 1; i <= step; i++) {
                $(`.wizard .step.form-step${i}`).addClass('active');
            }
            $(window).resize();
        }, 200);
    });

    $(document).on('click', '.wizard-prev,.wizard-next', function () {
        var step = parseInt($(this).data('step'));
        if ($(this).hasClass('wizard-prev')) {
            step--;
        } else {
            step++;
        }
        $(".form-step" + step).click();

    });

    isInit = true;

});
