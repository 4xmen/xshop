var isW8 = false;
// var descBody = $("#description").val();

$(function () {


    window.fakerProduct = function () {
        $("#name").val("Product name sample 1");
        $("#price").val("100000");
        $("#excerpt").val("گروه سوم، شامل افرادی می‌شود که قوانین اولیه قدرت و استراتژی را درک می‌کنند. پایان در هر زمینه‌ای مانند یک پروژه، یک مبارزه‌ی انتخاباتی یا یک گفت و گو، اهمیت فوق العاده ای برای مردم دارد. این اتفاق در ذهن ثبت می‌شود. یک جنگ می‌تواند با هیاهوی بسیار شروع شود و پیروزی‌های بسیاری را به ارمغان بیاورد؛ اما اینکه چگونه به پایان می‌رسد، در یادها می‌ماند و کسی به شروع پرهیاهو اهمیتی نمی‌دهد و تنها شاید این هیاهو برای لحظه‌ای ذهنشان را درگیر کند.");
        $("#description").val("گروه سوم، شامل افرادی می‌شود که قوانین اولیه قدرت و استراتژی را درک می‌کنند. پایان در هر زمینه‌ای مانند یک پروژه، یک مبارزه‌ی انتخاباتی یا یک گفت و گو، اهمیت فوق العاده ای برای مردم دارد. این اتفاق در ذهن ثبت می‌شود. یک جنگ می‌تواند با هیاهوی بسیار شروع شود و پیروزی‌های بسیاری را به ارمغان بیاورد؛ اما اینکه چگونه به پایان می‌رسد، در یادها می‌ماند و کسی به شروع پرهیاهو اهمیتی نمی‌دهد و تنها شاید این هیاهو برای لحظه‌ای ذهنشان را درگیر کند.");
        $("#weight").val("10.5");
        $("#color").val("رزد گلد");
        $("#width").val("34");
    };
    // fakerProduct();
    $('#discounts .btn-danger').click(function () {
        try {

            let id = $(this).data('id');
            let x = JSON.parse($("#discount-rem").val());
            x.push(id);
            $("#discount-rem").val(JSON.stringify(x));
            $(this).closest('tr').slideUp(300);

        } catch {
        }
    });

    $("#saveProduct").bind('submit', function (e) {
        e.preventDefault();

        if (isW8) {
            return false;
        }

        var formData = new FormData(document.querySelector('#saveProduct'));
        var j = 1;
        for (const f of uploadFormData) {
            if (uploadFormData.length == j) {
                break;
            }
            j++;
            try {
                if (f.size == undefined) {
                    continue;
                }
            } catch (e) {
                continue;
                // console.log(e.message);
            }

            formData.append('image[]', f);
        }

        $("[type='submit']").attr('disabled');//.addClass('w8');
        $("[type='submit']").addClass('w8');
        isW8 = true;


        let url = $(this).attr('action');

        // formData.set('desc',$("#description").val());
        // console.log('form Product data', formData);
        axios({
            method: 'post',
            url: url,
            data: formData,
            headers: {'Content-Type': 'multipart/form-data'}
        }).then(function (res) {

            $("[type='submit']").removeAttr('disabled').removeClass('w8');
            isW8 = false;
            if (res.data.OK) {
                if (res.data.url != undefined) {
                    window.location.href = res.data.url;
                } else {
                    if (res.data.link !== undefined){
                        $("#saveProduct").attr('action',res.data.link)
                    }
                    if ($("#price-amount").val().trim() !== '') {
                        window.location.reload();
                    }
                }
            }
        }).catch(error => {
            // console.log(error.response.data.errors);
            $(".is-invalid").removeClass('is-invalid');
            $("[type='submit']").removeAttr('disabled').removeClass('w8');
            isW8 = false;
            for (var i in error.response.data.errors) {
                $("#" + i).addClass('is-invalid');
                for (const err of error.response.data.errors[i]) {
                    alertify.error(err);
                }

            }

        });


    });

});
