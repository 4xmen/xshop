
var chosen = function () {
    try {
        require('../plugins/easySelect/easySelect');
       $('.mxsel').easySelect({
           buttons: true, //
           search: true,
           placeholderColor: '#524781',
           selectColor: '#524781',
           showEachItem: true,
           width: '100%',
           dropdownMaxHeight: '450px',
       });
    } catch(e) {
        console.log(e.message);
    }


};
window.canSubmit = true;
window.metaStore = [];
var myserilize = function (form) {
    var valz = $(form).serializeArray();
    var back = {};
    for (const i in valz) {
        let item = valz[i];
        back[item['name']] = item['value'];
    }
    return back;
};

var maxHeight = function (elems) {
    return Math.max.apply(null, elems.map(function () {
        return $(this).height();
    }).get());
};

Object.size = function (obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

var resizer = function () {
    // $(".comp h3").css('height', 'auto');
    // $(".comp h4").css('height', 'auto');
    // $(".comp h3").css('height', maxHeight($(".comp h3")) + 'px');
    // $(".comp h4").css('height', maxHeight($(".comp h4")) + 'px');
};

function makeTimer() {

    //		var endTime = new Date("29 April 2018 9:56:00 GMT+01:00");
    var endTime = new Date($("#finish_at").val());
    endTime = (Date.parse(endTime) / 1000);

    var now = new Date();
    now = (Date.parse(now) / 1000);

    var timeLeft = endTime - now;

    var days = Math.floor(timeLeft / 86400);
    var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
    var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60);
    var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

    if (hours < "10") {
        hours = "0" + hours;
    }
    if (minutes < "10") {
        minutes = "0" + minutes;
    }
    if (seconds < "10") {
        seconds = "0" + seconds;
    }

    $("#days").html(days + "<span>Days</span>");
    $("#hours").html(hours + "<span>Hours</span>");
    $("#minutes").html(minutes + "<span>Minutes</span>");
    $("#seconds").html(seconds + "<span>Seconds</span>");

}


var formCreator = function (that, nosearch, val) {
    let url = $(that).data('url');
    if (val == '' || val == null) {
        return false;
    }
    axios.get(url + val).then(r => {
        // console.log(r.data);
        try {
            var defs = JSON.parse($("#metaz").val());
            if(defs.weight!== undefined){
                $("#weight").val(defs.weight);
            }
            // console.log(defs);
        } catch (e) {
            var defs = [];
        }

        // alertify.success(`The advertiser <em>${adTitle}</em> deleted.`);
        // window.location.reload();
        $("#meta").html('');
        // $(".xtitle").text(r.data[0].price_title);
        var outTxt = '';
        var pricing = '';
        for (const i in r.data[1]) {
            var item = r.data[1][i];
            if (item.request && nosearch) {
                var req = 'required=""';
            } else {
                var req = '';
            }
            if (item.searchable == 0 && !nosearch) {
                continue;
            }
            var tmp = '<div class="form-group ' + item.width + '">';
            if (item.type != 'checkbox' && item.type != 'radio' && item.type != 'multilevel') {
                tmp += '<label for="' + item.name + '"> ' + item.label + ' </label>';
            } else if (item.type == 'multilevel') {
                var lbls = item.label.toString().split('/');
                // console.log(lbls);
            } else {
                tmp += '<label> ' + item.label + ' </label> <br >';
            }


            if (item.type == 'text' || item.type == 'number') {
                if (defs[item.name] != undefined) {
                    var valc = ' value="' + defs[item.name] + '" ';
                } else {
                    var valc = '';
                }
                tmp += '<input ' + req + ' type="' + item.type + '"' + valc + ' class="form-control" id="' + item.name + '" name="meta[' + item.name + ']" >';
            }
            if ((item.type == 'numberrange' || item.type == 'numberrangesel') && nosearch) {
                if (defs[item.name] != undefined) {
                    var valc = ' value="' + defs[item.name] + '" ';
                } else {
                    var valc = '';
                }
                tmp += '<input ' + req + ' type="number"' + valc + ' class="form-control" id="' + item.name + '" name="meta[' + item.name + ']" >';
            }
            if (item.type == 'numberrange' && !nosearch) {
                if (defs[item.name] != undefined) {
                    var valc = ' value="' + defs[item.name] + '" ';
                } else {
                    var valc = '';
                }
                tmp += '<br>';
                tmp += '<div class="row">';
                tmp += '<div class="col-6"><input  ' + req + ' type="number"' + valc + ' placeholder="From" class="form-control numberrange" name="meta[' + item.name + '][from]" ></div>';
                tmp += '<div class="col-6"><input ' + req + ' type="number"' + valc + ' placeholder="To" class="form-control numberrange"  name="meta[' + item.name + '][to]" ></div>';
                tmp += '</div>';
            }
            if (item.type == 'numberrangesel' && !nosearch) {
                if (defs[item.name] != undefined) {
                    var valc = ' value="' + defs[item.name] + '" ';
                } else {
                    var valc = '';
                }

                var vals = JSON.parse(item.options);
                var itm1 = '<option value="">From</option>';
                var itm2 = '<option value="">To</option>';
                for (const ix in vals) {
                    let val = vals[ix].split('|');
                    if (defs[item.name] != undefined && defs[item.name] == val[0]) {
                        var valc = ' selected=""';
                    } else {
                        var valc = '';
                    }
                    if (defs[item.name] != undefined && defs[item.name] == val[1]) {
                        var valc2 = ' selected=""';
                    } else {
                        var valc2 = '';
                    }
                    itm1 += '<option ' + valc + ' value="' + val[0] + '">' + val[0] + '</option>';
                    itm2 += '<option ' + valc2 + ' value="' + val[1] + '">' + val[1] + '</option>';
                }

                tmp += '<br>';
                tmp += '<div class="row">';
                tmp += '<div class="col-6"><select  ' + req + '  class="form-control numberrange" name="meta[' + item.name + '][from]" >' + itm1 + '</select></div>';
                tmp += '<div class="col-6"><select ' + req + '  class="form-control numberrange"  name="meta[' + item.name + '][to]" >' + itm2 + '</select></div>';
                tmp += '</div>';
            }

            if (item.type == 'checkbox') {
                if (defs[item.name] != undefined) {
                    var valc = ' checked=""';
                } else {
                    var valc = '';
                }
                tmp += '<input ' + req + ' type="' + item.type + '"  ' + valc + ' id="' + item.name + '" value="1" name="meta[' + item.name + ']" >';
                tmp += '&nbsp;<label for="' + item.name + '"> ' + item.label + ' </label>';
            }
            if (item.type == 'radio') {
                var vals = JSON.parse(item.options);
                for (const ix in vals) {
                    let val = vals[ix];
                    if (defs[item.name] != undefined && defs[item.name] == val) {
                        var valc = ' checked=""';
                    } else {
                        var valc = '';
                    }
                    tmp += '<input ' + req + ' type="' + item.type + '"  ' + valc + ' id="' + item.name + ix + '" value="' + val + '" name="meta[' + item.name + ']" >';
                    tmp += '&nbsp;<label for="' + item.name + ix + '"> ' + val + ' </label>&nbsp;&nbsp;&nbsp;&nbsp;';
                }
            }

            if (item.type == 'select' || (item.type == 'singlemulti' && nosearch)) {

                if (item.type == 'select') {
                    var suffix = '';
                } else {
                    var suffix = '[]';
                }
                var vals = JSON.parse(item.options);
                tmp += '<select ' + req + ' class="form-control" id="' + item.name + '" name="meta[' + item.name + ']' + suffix + '">';
                if (item.type == 'select' && !nosearch) {
                    tmp += '<option value=""> Alla </option>';
                }
                for (const ix in vals) {
                    let val = vals[ix];
                    if (defs[item.name] != undefined && defs[item.name] == val) {
                        var valc = ' selected=""';
                    } else {
                        var valc = '';
                    }
                    tmp += '<option ' + valc + ' value="' + val + '">' + val + '</option>';
                }
                tmp += '</select>';
            }

            if (item.type == 'multi' || (item.type == 'singlemulti' && !nosearch)) {
                var vals = JSON.parse(item.options);

                tmp += '<select ' + req + ' class="form-control mxsel" multiple="multiple" id="' + item.name + '" name="meta[' + item.name + '][]">';
                for (const ix in vals) {
                    let val = vals[ix];
                    try {

                        if (defs[item.name] != undefined && defs[item.name].indexOf(val) != -1) {
                            var valc = ' selected=""';
                        } else {
                            var valc = '';
                        }
                    } catch (e) {
                        var valc = '';
                    }
                    tmp += '<option ' + valc + ' value="' + val + '">' + val + '</option>';
                }
                tmp += '</select>';
            }

            if (item.type == 'multilevel' && nosearch) {


                if (item.type == 'select') {
                    var suffix = '';
                } else {
                    var suffix = '[]';
                }
                var vals = JSON.parse(item.options);

                window.metaStore[item.name] = vals;


                var twostep = '';
                tmp += '<div class="row">';
                tmp += '<div class="col-6">';
                tmp += `<label for="${item.name}"  >${lbls[0]}</label>`;

                tmp += '<select ' + req + ' class="form-control multimeta" id="' + item.name + '" name="meta[' + item.name + ']' + suffix + '">';
                tmp += `<option selected value="">Choose</option>`;
                for (const ix in vals) {
                    let val = vals[ix];
                    if (defs[item.name] != undefined && defs[item.name] == val.title) {
                        var valc = ' selected=""';
                        twostep = val.title;
                    } else {
                        var valc = '';
                    }
                    tmp += '<option ' + valc + ' value="' + val.title + '">' + val.title + '</option>';
                }
                tmp += '</select>';
                tmp += '</div><div class="col-6">';

                tmp += `<label for="${item.name}_"  >${lbls[1]}</label>`;
                var ttmp = '';
                if (twostep != '') {

                    for (const ixx in window.metaStore[item.name]) {
                        let bbb = window.metaStore[item.name][ixx];
                        if (bbb.title == twostep) {
                            for (const jxx in bbb.children) {
                                let ccc = bbb.children[jxx];
                                if (defs[item.name + '_'] != undefined && defs[item.name + '_'] == ccc) {
                                    var valc = ' selected=""';
                                } else {
                                    var valc = '';
                                }
                                ttmp += `<option ${valc} value="${ccc}">${ccc}</option>`
                            }
                            break;
                        }
                    }
                }

                tmp += `<select id="${item.name}_" class="form-control" name="meta[${item.name}_]">${ttmp}</select>`;
                tmp += '</div> </div>'
            }

            if ((item.type == 'multilevel' && !nosearch)) {


                if (item.type == 'select') {
                    var suffix = '';
                } else {
                    var suffix = '[]';
                }
                var vals = JSON.parse(item.options);

                window.metaStore[item.name] = vals;

                tmp += '<div class="row">';
                tmp += '<div class="col-6">';
                tmp += `<label for="${item.name}"  >${lbls[0]}</label>`;
                tmp += '<select ' + req + ' class="form-control mxsel smultimeta" multiple="multiple"  id="' + item.name + '" name="meta[' + item.name + '][]' + suffix + '">';
                for (const ix in vals) {
                    let val = vals[ix];
                    // if (defs[item.name] != undefined && defs[item.name].indexOf(val.title) != -1) {
                    //     var valc = ' selected=""';
                    // } else {
                    var valc = '';
                    // }
                    tmp += '<option ' + valc + ' value="' + val.title + '">' + val.title + '</option>';
                }
                tmp += '</select>';
                tmp += '</div><div class="col-6">';


                tmp += `<label for="${item.name}_"  >${lbls[1]}</label>`;
                tmp += `<select id="${item.name}_" class="form-control mxsel" multiple="multiple"  name="meta[${item.name}_][]"></select>`;
                tmp += '</div> </div>'

            }


            tmp += '</div>';
            outTxt += tmp;
        }
        $("#meta").append(outTxt);

        let metaList = [];

        for( const meta of r.data[1]) {
            if (meta.priceable){
                metaList.push(meta);
            }
        }

        window.app.$refs.mtz.dataz = metaList;
        console.log(metaList);





        try {
            chosen();
        } catch(e) {
            console.log(e.message);
        }

    }, r => alertify.error(`Error  get props !`));
};

$(document).ready(function () {
    // $.fn.select2.defaults.set("theme", "bootstrap4");
    // $.fn.select2.defaults.set("language", "sv");
    // $(`select[name='category']`).select2({allowClear: true, placeholder: 'Select Category'});
    // $(`select[name='towns[]']`).select2({placeholder: 'Select Towns'});

    $("#xtype").off('change').bind('change',function () {
       $("#optionz,#xls-file").hide();
       var sel = ['numberrangesel','radio','select','multi','singlemulti'];
       if($(this).val() == 'multilevel'){
           $("#xls-file").show();
       }
       if (sel.indexOf($(this).val()) != -1){
           $("#optionz").show();
       }
       $(window).resize();
    });

    setTimeout(function () {
        $("#xtype").change();
    },300);
    //
    // $('.cdelete').on('click', function () {
    //     if (!confirm("Are you sure to remove this item?")) {
    //         return false;
    //     }
    // });

    if ($("#btype").length != 0) {
        $("#pv").val($("#btype").val());
    }

    $(document).on('change', '#categoryId,#category_id', function () {
        if ($(this).attr('id') == 'categoryId') {
            formCreator(this, true, $(this).val());
        } else {
            formCreator(this, false, $(this).val());
        }
    });
    $(document).on('change', '#store_category_id', function () {
        formCreator(this, true, $(this).find(':selected').data('id'));
    });

    // barnd / model multilevel no search no multi
    $(document).on('change', '.multimeta', function () {
        var id = '#' + $(this).attr('id') + '_';
        if ($(this).val() != '') {
            var tmp = '';
            for (const ixx in window.metaStore[$(this).attr('id')]) {
                let bbb = window.metaStore[$(this).attr('id')][ixx];
                if (bbb.title == $(this).val()) {
                    tmp += `<option value="" selected=""></option>`
                    for (const jxx in bbb.children) {
                        let ccc = bbb.children[jxx];
                        tmp += `<option value="${ccc}">${ccc}</option>`
                    }
                    break;
                }
            }
            $(id).html(tmp);
        }
    });
    // barnd / model multilevel search & multi
    $(document).on('change', '.smultimeta', function () {
        var id = '#' + $(this).attr('id') + '_';
        if ($(this).val() != []) {
            var tmp = '';
            for (const ixx in window.metaStore[$(this).attr('id')]) {
                let bbb = window.metaStore[$(this).attr('id')][ixx];
                // if (bbb.title == $(this).val()) {
                if ($(this).val().indexOf(bbb.title) != -1) {
                    for (const jxx in bbb.children) {
                        let ccc = bbb.children[jxx];
                        tmp += `<option value="${ccc}">${ccc}</option>`
                    }
                }
            }
            $(id).html(tmp);

        }
    });

    if ($("#meta").length > 0) {
        $('#categoryId,#category_id').change();
    }

    try {
        $("#store_category_id").change();
    } catch (e) {
    }


    var groupc = $(".srt").sortable({
        group: 'sorting',
        onDrop: function ($item, container, _super) {
            var data = groupc.sortable("serialize").get()[0];
            var jsonString = JSON.stringify(data);
            console.log(jsonString);
            $("#sort-result").val(jsonString);
            _super($item, container);
        }
    });

    $(".set-sreach-mode").click(function () {
        let url = ($("#search-mode").val() + $(this).data('val'));
        var that = this;
        axios.get(url).then(r => {
            if (r.data.ok != true) {
                alertify.error(`cant save search view mode`);
                return;
            }
            $(".search-mode .btn").toggleClass('btn-primary');
            $(".search-mode .btn").toggleClass('btn-secondary');
            if ($(that).data('val') == 'list') {
                $("#ad-list-infinite").removeClass('grid-view');
            } else {
                $("#ad-list-infinite").addClass('grid-view');
            }
            // $(that).addClass('btn-primary');

        });
    });



    var basec = 0;
    var basefiles = {};
    $("#customFileLang").change(function (e) {
        var txt = '';
        // console.log(Object.size(basefiles));
        var x = Object.size(basefiles);
        for (var i = 0; i < Math.min((e.target.files.length), 10 - x); i++) {
            // formData.append('images[]', e.target.files[i], e.target.files[i].name);
            basefiles[basec] = e.target.files[i];
            txt += '<div class="prevw"  data-id="' + basec + '" style="background-image: url(' + URL.createObjectURL(e.target.files[i]) + ')">';
            txt += '<i class="fa fa-times"></i>';
            txt += '</div>';
            basec++;

            // $("#toUpload")[0].files.ap = e.target.files[i];
        }
        $(".gopreview").html('').removeClass('gopreview');
        $("#preview").append(txt);
        $(".prevw").css('width', Math.floor($("#preview").width() / 4) - 7);
        $(".prevw").css('height', Math.floor($("#preview").width() / 4) - 7);

    });

    $(document).on('click', ".prevw .fa-times", function () {
        var id = $(this).parent().data('id');
        delete basefiles[id];
        $(this).parent().hide(300, function () {
            $(this).remove();
        });
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() >= 100) {
            $("#go-top").fadeIn(300);
        } else {
            $("#go-top").fadeOut(300);
        }
    });

    $("#go-top").click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 1000);
    });


    $("#add-form").submit(function (e) {

        e.preventDefault();

        if (!window.canSubmit) {
            return false;
        }

        window.canSubmit = false;
        var valz = myserilize("#add-form");
        var formData = new FormData();
        for (const i in basefiles) {
            var f = basefiles[i];
            formData.append('images[]', f, f.name);
        }
        for (const i in valz) {
            var item = valz[i];
            formData.append(i, item);
        }

        // console.log(valz);
        // console.log(formData);
        //
        // for (var value of formData.values()) {
        //     console.log(value);
        // }

        $("#premodal").fadeIn(300);
        axios({
            method: 'post',
            url: $("#ajurl").val(),
            data: formData,
            config: {headers: {'Content-Type': 'multipart/form-data'}}
        })
            .then(function (response) {
                $("#premodal").slideUp(300);
                if (response.data.ok == true) {
                    window.location.href = $("#ad-redirect").val() + '/' + response.data.data.id;
                } else {
                    window.canSubmit = true;
                }
            })
            .catch(function (err) {
                $("#premodal").slideUp(300);
                try {

                    window.canSubmit = true;
                    if (err.response.status == 401) {
                        alertify.error('Authenticnation Error');
                        // window.location.href = '/#/login';
                    } else if (err.response.status == 422) {
                        // console.log(err.response.data.errors);
                        for (const k in err.response.data.errors) {
                            let er = err.response.data.errors[k];
                            console.log(er);
                            alertify.error(k + ' : ' + er[0]);
                        }

                    } else {
                        alertify.error('Error' + err.response.status + ': ' + err.response.data.message);
                    }

                } catch (ec) {
                    // console.log(ec.message);
                }

            });
        return false;
    });

    $("#productStore").submit(function (e) {

        e.preventDefault();

        if (!window.canSubmit) {
            return false;
        }

        window.canSubmit = false;
        var valz = myserilize("#productStore");
        var formData = new FormData();
        for (const i in basefiles) {
            var f = basefiles[i];
            formData.append('images[]', f, f.name);
        }
        for (const i in valz) {
            var item = valz[i];
            formData.append(i, item);
        }

        // console.log(valz);
        // console.log(formData);
        //
        // for (var value of formData.values()) {
        //     console.log(value);
        // }

        $("#premodal").fadeIn(300);
        axios({
            method: 'post',
            url: $(this).attr('action'),
            data: formData,
            config: {headers: {'Content-Type': 'multipart/form-data'}}
        })
            .then(function (response) {
                $("#premodal").slideUp(300);
                if (response.data.ok == true) {
                    window.location.href = $("#ad-redirect").val();
                } else {
                    window.canSubmit = true;
                }
            })
            .catch(function (err) {
                $("#premodal").slideUp(300);
                try {

                    window.canSubmit = true;
                    if (err.response.status == 401) {
                        alertify.error('Authenticnation Error');
                        // window.location.href = '/#/login';
                    } else if (err.response.status == 422) {
                        // console.log(err.response.data.errors);
                        for (const k in err.response.data.errors) {
                            let er = err.response.data.errors[k];
                            console.log(er);
                            alertify.error(k + ' : ' + er[0]);
                        }

                    } else {
                        alertify.error('Error' + err.response.status + ': ' + err.response.data.message);
                    }

                } catch (ec) {
                    // console.log(ec.message);
                }

            });
        return false;
    });

    $("#saveSortCat").click(function () {
        if ($("#serialize_output").val() == '') {
            alertify.error("Not changed any thing");
            return false;
        }
        $("#premodal").fadeIn(300);
        axios({
            method: 'put',
            url: $("#route").val(),
            data: {sort: $("#serialize_output").val()}
        }).then(function (response) {
            $("#premodal").slideUp(300);
            alertify.success(response.data.message);
        })
            .catch(function (err) {
                $("#premodal").slideUp(300);
                try {

                    window.canSubmit = true;
                    if (err.response.status == 401) {
                        alertify.error('Authenticnation Error');
                        // window.location.href = '/#/login';
                    } else if (err.response.status == 422) {
                        // console.log(err.response.data.errors);
                        for (const k in err.response.data.errors) {
                            let er = err.response.data.errors[k];
                            console.log(er);
                            alertify.error(k + ' : ' + er[0]);
                        }

                    } else {
                        alertify.error('Error' + err.response.status + ': ' + err.response.data.message);
                    }

                } catch (ec) {
                    // console.log(ec.message);
                }

            });
    });

    // $('.parallax').parallax();


    // $(document).on('click', '.nexprv', function () {
    //     $($(this).data('show')).slideDown(300);
    //     $($(this).data('hide')).slideUp(300);
    //     $(".donable").removeClass('done');
    //     $($(this).data('done')).addClass('done');
    //
    //     return false;
    // });


    var group = $("#catsort").sortable({
        group: 'serialization',
        delay: 500,
        onDrop: function ($item, container, _super) {
            var data = group.sortable("serialize").get();

            var jsonString = JSON.stringify(data, null, ' ');

            $('#serialize_output').val(jsonString);
            _super($item, container);
        }
    });

    // $(".typewriter").typewriter({'speed': 100});
    //
    // $('.marquee').marquee();

    // const WOW = require('wowjs/dist/wow.min');
    //
    //
    // window.wow = new WOW.WOW(
    //     {
    //         boxClass: 'wow',      // animated element css class (default is wow)
    //         animateClass: 'animated', // animation css class (default is animated)
    //         offset: 0,          // distance to the element when triggering the animation (default is 0)
    //         mobile: true,       // trigger animations on mobile devices (default is true)
    //         live: true,       // act on asynchronously loaded content (default is true)
    //         // callback:     function(box) {
    //         //     // the callback is fired every time an animation is started
    //         //     // the argument that is passed in is the DOM node being animated
    //         // },
    //         scrollContainer: null // optional scroll container selector, otherwise use window
    //     }
    // );
    // window.wow.init();
    //
    // $('#owl1').owlCarousel({
    //     loop: true,
    //     margin: 10,
    //     dots: true,
    //     autoHeight: true,
    //     autoplay: 5000,
    //     responsiveClass: true,
    //     responsive: {
    //         0: {
    //             items: 1,
    //             nav: true
    //         },
    //         600: {
    //             items: 2,
    //             nav: true
    //         },
    //         1000: {
    //             items: 3,
    //             nav: true,
    //             loop: true
    //         }
    //     },
    // });
    // $('.index-owl').owlCarousel({
    //     loop: true,
    //     margin: 10,
    //     dots: true,
    //     autoHeight: true,
    //     autoplay: 5000,
    //     responsiveClass: true,
    //     responsive: {
    //         0: {
    //             items: 1,
    //             nav: true
    //         },
    //         300: {
    //             items: 2,
    //             nav: true
    //         },
    //         600: {
    //             items: 3,
    //             nav: true,
    //             loop: true
    //         },
    //         1000: {
    //             items: 4,
    //             nav: true,
    //             loop: true
    //         }
    //     },
    // });

    // $('#datetimepicker').datetimepicker({
    //     locale: 'sv',
    //     // inline: true,
    //     defaultDate: moment().add(1, 'M').format('MM-DD-YYYY'),
    //     minDate: new Date(),
    // });

    // $(window).scroll(function () {
    //     var scroll = $(window).scrollTop();
    //     if (scroll <= 300) {
    //         $("#shop-menu").removeClass('full-opacity');
    //     } else {
    //         $("#shop-menu").addClass('full-opacity');
    //     }
    // });

    $(".frm-safe").submit(function () {
        $(this).attr('action', $("#act").val());
    });
    //
    // $(".rating").each(function () {
    //     for (var i = 1; i <= parseInt($($(this).data('id')).val()); i++) {
    //         $(`i[data-rate="${i}"]`).addClass('selected');
    //     }
    // });
    //
    // $(".rating .fa-star").hover(function () {
    //     var rate = $(this).data('rate');
    //     $(this).parent().find('.fa-star').removeClass('active');
    //     for (var i = 1; i <= rate; i++) {
    //         $(`i[data-rate="${i}"]`).addClass('active');
    //     }
    //
    // }, function () {
    //     $(this).parent().find('.fa-star').removeClass('active');
    // }).click(function () {
    //     var rate = $(this).data('rate');
    //     $(this).parent().find('.fa-star').removeClass('selected');
    //     for (var i = 1; i <= rate; i++) {
    //         $(`i[data-rate="${i}"]`).addClass('selected');
    //     }
    //
    //     $($(this).parent().data('id')).val(rate);
    //
    // });


    //
    // $(".show-rate").each(function () {
    //     var rate = Math.round($(this).data('rate'));
    //     if (rate != '') {
    //         let text = '';
    //         for (let i = 1; i <= 5; i++) {
    //             text += i <= rate ? '<i class="fa fa-star selected"></i>' : '<i class="fa fa-star"></i>';
    //         }
    //         $(this).html(text + '&nbsp;&nbsp; <b>' + $(this).data('rate') + '</b>&nbsp;&nbsp; &nbsp;&nbsp; ');
    //     }
    //     if (parseInt(rate) == '0') {
    //         $(this).html(`
    //         <i class="fa fa-star red"></i>
    //         <i class="fa fa-star red"></i>
    //         <i class="fa fa-star red"></i>
    //         <i class="fa fa-star red"></i>
    //         <i class="fa fa-star red"></i>
    //         -
    //         `);
    //     }
    //
    // });
    //
    // $(".add-compare").click(function (e) {
    //     e.preventDefault();
    //     var url = $("#compareURL").val() + '/' + $(this).data('slug');
    //     $("#premodal").slideDown(300);
    //     axios({
    //         method: 'get',
    //         url: url,
    //         config: {headers: {'Content-Type': 'multipart/form-data'}}
    //     })
    //         .then(function (response) {
    //             $("#premodal").slideUp(300);
    //             if (response.data.ok == true) {
    //                 // window.location.href = $("#ad-redirect").val();
    //                 alertify.success(response.data.message);
    //                 $("#compareMenu").show();
    //                 if (response.data.data.count > 1) {
    //                     $("#compareMenu a").removeClass('disabled');
    //                     $("#compCount").text(response.data.data.count);
    //                 }
    //             } else {
    //                 // window.canSubmit = true;
    //             }
    //         })
    //         .catch(function (err) {
    //             $("#premodal").slideUp(300);
    //             try {
    //
    //                 window.canSubmit = true;
    //                 if (err.response.status == 401) {
    //                     alertify.error('Authenticnation Error');
    //                     // window.location.href = '/#/login';
    //                 } else if (err.response.status == 422) {
    //                     // console.log(err.response.data.errors);
    //                     for (const k in err.response.data.errors) {
    //                         let er = err.response.data.errors[k];
    //                         console.log(er);
    //                         alertify.error(k + ' : ' + er[0]);
    //                     }
    //
    //                 } else {
    //                     alertify.error('Error' + err.response.status + ': ' + err.response.data.message);
    //                 }
    //
    //             } catch (ec) {
    //                 // console.log(ec.message);
    //             }
    //
    //         });
    // });



});
