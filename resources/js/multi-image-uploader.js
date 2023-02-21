// var uploadFormData = [];

function previewImage(input, i) {
    try {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(input);

        oFReader.onload = function (oFREvent) {
            let img = oFREvent.target.result;
            $("#uploading-images").append(`<div data-id="${i}" class="col-xl-3 col-md-4 border p-3">
                                    <div class="img-preview" style="background-image: url('${img}')"></div>
                                    <div class="btn btn-danger upload-remove-image">
                                        <span class="fa fa-trash"></span>
                                    </div>
                                </div>`);
        };
        if (xTimer != undefined){
            clearTimeout(xTimer);
        }
        var xTimer = setTimeout(function () {
            $('.img-preview').css('height',$('.img-preview').width()+'px');
            $(window).resize();
        }, 300);
    } catch (e) {
    }

};
jQuery(function () {

    $("#uploading-images .image-index").bind('dblclick',function () {
      $('.indexed').removeClass('indexed');
      $(this).addClass('indexed');
      $("#indexImage").val($(this).data('key'));
    })
    $('.img-preview').height($('.img-preview').width());

    $("#upload-drag-drop").off('click').bind('click',function () {

        $("#upload-image-select").off('click').click();
    });
    $("#upload-image-select").off('change').bind('change', function () {
        for (const i in $(this)[0].files) {
            var file = $(this)[0].files[i];
            uploadFormData.push(file);
            previewImage(file, uploadFormData.length);
        }
    });
    $(document).on('click',".upload-remove-image",function () {
        var data = $(this).closest('.col-md-4').data('id');
        delete uploadFormData[data-1];
        $(this).closest('.col-md-4').slideUp(400, function () {
            $(this).remove();
        });
    });

    $('#upload-drag-drop').off('dragover').on(
        'dragover',
        function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass(".active");
        }
    );
    $('#upload-drag-drop').off('dragenter').off('dragstart').on(
        'dragenter dragstart',
        function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass("active");
        }
    );
    $('#upload-drag-drop').off('dragend').off('ondragleave').bind(
        'ondragleave dragend',
        function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass("active");
        }
    );

    $('#upload-drag-drop').off('drop').on(
        'drop',
        function(e){
            $(this).removeClass("active");
            if(e.originalEvent.dataTransfer && e.originalEvent.dataTransfer.files.length) {
                e.preventDefault();
                e.stopPropagation();
                /*UPLOAD FILES HERE*/
                for( const f of e.originalEvent.dataTransfer.files) {
                    previewImage(f, uploadFormData.length);
                }

            }
        }
    );
});
