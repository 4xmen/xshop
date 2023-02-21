jQuery(function ($) {

    jQuery(document).on('change', '#categoryId', function () {
        let url = $(this).data('url')+$(this).val();
        // let val = ;
        $.get(url,function (e) {
            console.log(app.jdata );
            app.jdata = e[1];
            console.log(app.jdata );
        });
    });

    jQuery("#xtype").bind('change', function () {
        let t = $(this).val();
        let op = [];
        try {
            op = JSON.parse($("#options").val());
        } catch {
            console.log('no');
        }
        let txt = '';
        if (t == 'select' || t == 'multi' || t == 'singlemulti' || t == 'color') {
            for (const o of op) {
                let ttyupe = 'text';
                if (t == 'color') {
                    ttyupe = 'color';
                }
                txt += `<div>
                <div class="row">
                    <div class="col-md-5 mt2 mb-1">
                        <input type="text" class="form-control" name="options[title][]" placeholder="title" value="${o.title}">
                    </div>
                    <div class="col-md-6 mt2 mb-1">
                        <input type="${ttyupe}" class="form-control" name="options[value][]" placeholder="value" value="${o.value}">
                    </div>
                    <div class="col-md-1">
                        <div class="btn btn-danger rem-op">
                            <i class="fa fa-times"></i>
                        </div>
                    </div>
                </div>
            </div>`;
            }
            $("#xoptions .content").html(txt).parent().show();

            $(".rem-op").click(function () {
                $(this).closest('.row').remove();
            })
        } else {
            $("#xoptions").hide();
        }

    });

    $("#add-options").bind('click', function () {
        let t = $("#xtype").val();
        let ttyupe = 'text';
        if (t == 'color') {
            ttyupe = 'color';
        }
        txt = `<div>
                <div class="row">
                    <div class="col-md-5 mt2 mb-1">
                        <input type="text" class="form-control" name="options[title][]" placeholder="title" >
                    </div>
                    <div class="col-md-6 mt2 mb-1">
                        <input type="${ttyupe}" class="form-control" name="options[value][]" placeholder="value" >
                    </div>
                    <div class="col-md-1">
                        <div class="btn btn-danger rem-op">
                            <i class="fa fa-times"></i>
                        </div>
                    </div>
                </div>
            </div>`;

        $("#xoptions .content").append(txt);
        $(".rem-op").click(function () {
            $(this).closest('.row').remove();
        })
    });

    jQuery("#xtype").change();

    setTimeout(function () {
        jQuery("#xtype").change();
    },1000)



});
