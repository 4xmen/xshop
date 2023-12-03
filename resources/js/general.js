jQuery(function () {
    $("nav [href='" + window.location.href + "']").closest('li').addClass('current');
    // console.log(
    setTimeout(function () {
        if ($("nav .current").closest('.main-nav').find('> a').attr('href') == undefined) {
            $("nav .current").closest('.main-nav').find('> a').click();
        }
        if ($("nav .current").parent().parent().hasClass('rvnm-expandable')) {
            $("nav .current").parent().parent().find('> a').click();
        }
    }, 500);

    $("#menu-manage li").bind('dblclick', function () {
        if (confirm('Are sure?')) {
            let self = this;
            axios.post($("#rem-menu").val() + '/' + $(this).data('menuableid')).then(function () {
                $(self).slideUp();
            });
        }
    });

    window.addEventListener('load', function () {
        let dirx= 'rtl';
        if (!isRtl) {
            document.querySelector('body').style.direction = 'ltr';
            dirx = 'ltr';
        }
        try {
            for(let instanceName in CKEDITOR.instances){
                CKEDITOR.instances[instanceName].destroy();
            }
        } catch(e) {
            console.log(e.message);
        }

        $(".ckeditorx").each(function (i,e) {
            CKEDITOR.replace($(e).attr('name'), {
                filebrowserUploadUrl: xupload,
                filebrowserUploadMethod: 'form',
                contentsLangDirection: dirx,
            });

        });
        if ($("[name='desc']#description").length) {
            CKEDITOR.replace('description', {
                filebrowserUploadUrl: xupload,
                filebrowserUploadMethod: 'form',
                contentsLangDirection: isRtl?'rtl':'ltr',
            });
            CKEDITOR.instances.description.on('change',function () {
                $("#description").val(CKEDITOR.instances.description.getData());
            });
        }
        // },1000);
    })
    // );
    // $("nav .current").closest('li').click();
});
