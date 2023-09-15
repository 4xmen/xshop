// require('hc-offcanvas-nav/dist/hc-offcanvas-nav');
// import xMegaMenu from 'x-mega-menu/src/x-mega-menu';
import xm from 'x-mega-menu/dist/x-mega-menu.min';

let xMegaMenu = window.xMegaMenu = xm.xMegaMenu;

function CopyToClipboard(containerid) {
    if (window.getSelection) {
        if (window.getSelection().empty) { // Chrome
            window.getSelection().empty();
        } else if (window.getSelection().removeAllRanges) { // Firefox
            window.getSelection().removeAllRanges();
        }
    } else if (document.selection) { // IE?
        document.selection.empty();
    }

    if (document.selection) {
        var range = document.body.createTextRange();
        range.moveToElementText(document.getElementById(containerid));
        range.select().createTextRange();
        document.execCommand("copy");
    } else if (window.getSelection) {
        var range = document.createRange();
        range.selectNode(document.getElementById(containerid));
        window.getSelection().addRange(range);
        document.execCommand("copy");
    }

    alertify.success('کپی شد');
}

function commafy(num) {
    var str = num.toString().split('.');
    if (str[0].length >= 4) {

        str[0] = str[0].replace(/(\d)(?=(\d{3})+$)/g, '$1,');
    }
    if (str[1] && str[1].length >= 4) {

        str[1] = str[1].replace(/(\d{3})/g, '$1,');
    }
    return str.join('.');
}

let qnn, images, sizes;

jQuery(function ($) {

    try {
        xMegaMenu('#mega-menu', {
            responseWidth: 1124,
            isRtl: true,
            mainTitle: appName,
            blurEffect: true,
            disableLinks: false,
        });
    } catch(e) {
        console.log(e.message);
    }


   try {
       $(".xzoom, .xzoom-gallery").xzoom({tint: '#333', Xoffset: 15});
   } catch(e) {
   }


    $(window).on('load', function () {
        setTimeout(function () {
            $('#preloader').slideUp(700);
            // let max = 150 ;
            // for( const b of $(".box")) {
            //     if ($(b).height() > max ){
            //         max= $(b).height();
            //     }
            // }
            // $('.box').height(max);
            // $("#favs .box").removeAttr('style');

        }, 100);
    });
    setTimeout(function () {
        $('#preloader').slideUp(700);
    }, 100);

    setTimeout(function () {
        $('#preloader').slideUp(700);
    }, 10000);
    $("#toggle-side").bind('click', function () {
        $('aside > div').slideToggle(300);
    });

    $('.owl1').owlCarousel({
        loop: true,
        margin: 0,
        responsiveClass: true,
        // autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        item: 5,
        responsive: {
            0: {
                nav: false,
                items: 2,
            },
            600: {
                items: 2,
                nav: false,
                loop: false
            },
            1000: {
                items: 3,
                nav: false,
                loop: false
            },
            1300: {
                items: 5,
                nav: false,
                loop: false
            }
        }
    });
    $('#owl2').owlCarousel({
        loop: true,
        margin: 0,
        responsiveClass: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        item: 3,
        responsive: {
            0: {
                nav: false,
                items: 1,
            },
            600: {
                items: 2,
                nav: false,
                loop: false
            },
            1000: {
                items: 3,
                nav: false,
                loop: false
            },
        }
    });

    $('#thumbs').owlCarousel({
        loop: false,
        margin: 4,
        responsiveClass: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        items: 4,
        // nav: true,
    });
    $('.owl-single-item').owlCarousel({
        loop: true,
        margin: 0,
        responsiveClass: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        items: 1,
        // nav: true,
    });

    $('#owlx1').owlCarousel({
        loop: true,
        margin: 15,
        responsiveClass: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                nav: false,
                items: 1,
            },
            600: {
                items: 2,
                nav: false,
                loop: false
            },
            1000: {
                items: 3,
                nav: false,
                loop: false
            },
            1300: {
                items: 4,
                nav: false,
                loop: false
            }
        }
    });
    $('#owl3').owlCarousel({
        loop: false,
        margin: 0,
        responsiveClass: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        items: 1,
    });
    $('.owl-sq').owlCarousel({
        loop: true,
        margin: 0,
        responsiveClass: true,
        autoplay: true,
        autoplayTimeout: 5000,
        responsive: {
            0: {
                items: 2,
                nav: false
            },
            600: {
                items: 2,
            },
            1000: {
                items: 3,
            },
            1300: {
                items: 6,
            }
        }
    });

    $("#cp-deteail").bind('click',function () {
        CopyToClipboard('tab-analyze');
    });
    var axiosError = function (err) {
        if (err.response.status == 401) {
            alertify.error('Authenticnation Error');
            // window.location.href = '/#/login';
        } else if (err.response.status == 422) {
            // console.log(err.response.data.errors);
            for (const k in err.response.data.errors) {
                let er = err.response.data.errors[k];
                alertify.error(k + ' : ' + er[0]);
            }

        } else {
            alertify.error('Error' + err.response.status + ': ' + err.response.data.message);
        }
    }

    $("#filtering .btn").bind('click', function () {
        $("#filtering .btn").removeClass('active');
        $(this).addClass('active');
        let cls = $(this).data('cat');
        if (cls == 'all') {
            $("#da-thumbs .item").slideDown(900);
        } else {
            $("#da-thumbs .item").slideUp(600, function () {
                setTimeout(function () {
                    $("#da-thumbs .item." + cls).slideDown(513);
                }, 100);
            });
        }
    });

    $(".fav").bind('click',function () {
      let url = $("#fav-toggle").val()+'/'+$(this).data('id');
      let self = this;
      axios.get(url).then(function (e) {
        if (e.data.OK){
            alertify.success(e.data.msg);
            if (e.data.liked){
                $(self).addClass('liked');
            }else{
                $(self).removeClass('liked');
            }
        }else{
            alertify.error(e.data.msg);
        }
      });
    });

    $("#question-send").bind('click', function () {
        let data = {};
        for (const d of $("#question-form").serializeArray()) {
            data[d.name] = d.value;
        }

        axios.post($(this).data('url'), data).then(function (e) {
            if (e.data.OK) {
                alertify.success(e.data.msg);
                $(".comment-containerx").text(e.data.msg);
            }
        }).catch(function (e) {
            axiosError(e);
        });
    });

    $(".xsumbmiter").submit(function () {
        $(this).attr('action', $("#smt").val());
    });
    $(".comment-reply").click(function () {
        $('#reply').remove();
        var pid = $(this).data('id');
        $("#comment-form-body").append("<input type=\"hidden\" id=\"reply\" name=\"parent\" value=\"".concat(pid, "\" />"));
        $("#comment-message").focus();
    });

    $(".add-to-card").click(function (e) {
        e.preventDefault();
        axios.get($(this).attr('href')).then(function (e) {
            $("#card-count").text(e.data.data);
            window.alertify.message(e.data.msg);
            if (e.data.data > 0) {
                $("#card-info").fadeIn(400);
            }
        });
    });
    $(".add-to-card-q").click(function (e) {
        e.preventDefault();
        axios.get($(this).attr('href') + '/' + $("#qn").val()+'/'+$("#single-count").val()).then(function (e) {
            $("#card-count").text(e.data.data);
            window.alertify.message(e.data.msg);
            if (e.data.data > 0) {
                $("#card-info").fadeIn(400);
            }
        });
    });

    $("#addon-wrapping").bind('click', function () {
        let q = $("#searching").val();
        window.location.href = $("#searching").data('url') + '?q=' + q;
        return true;
    });
    $("#searching").bind('keyup', function (e) {
        let q = $(this).val();
        if (e.key === 'Enter') {
            window.location.href = $(this).data('url') + '?q=' + q;
            return true;
        }
        if (q.length < 3) {
            return 0;
        }
        let offset = $(this).offset();
        offset.width = ($(this).width() + 85) + 'px';
        offset.left -= 50;
        offset.top += 45;
        $("#search-list").css(offset).slideDown(100);
        let text = '';
        let self = this;
        $("#search-list").html(text + '<div class="p-4 text-center"><i class="fa fa-spin fa-spinner"></i></div>');
        axios.get($(this).data('ajax') + '?q=' + q).then(function (e) {
            if (!e.data.OK) {
                window.alertify.error(e.data.err);
            } else {
                text += '<ul class="list-group">';
                for (const p of e.data.data) {
                    text += '<li class="list-group-item">';
                    text += `<a href="${p.link}">`;
                    text += `<img src="${p.image}" alt="product image">`
                    text += `<h4>${p.name}</h4>`
                    text += `<h5>${p.price}</h5>`
                    text += '</a>';
                    text += '</li>';
                }
                text += '<li class="list-group-item">';
                text += '<a href="' + $(self).data('url') + '?q=' + q + '">';
                text += 'جستجو موارد بیشتر :';
                text += q;
                text += '</a>';
                text += '</li>';
                text += '</ul>';
                $("#search-list").html(text);

            }
        });
    });
    $(".xzoom-thumbs a").bind('click.light',function () {
      $("#lightbx").attr('href',$(this).attr('href'));
    });
    try {
        if ($('#qnt').length != 0) {
            sizes = {};
            let qnt = JSON.parse($('#qnt').val());
            console.log(qnt);
            let txt = '';
            for( const q of qnt) {
                if (q.count > 0){
                    let t = JSON.parse(q.data);
                    if (sizes[t.size] == undefined){
                        sizes[t.size]=[];
                        txt += `<div data-id="${t.size}" class="badge bg-secondary size">
                                               ${t.size}
                                </div> &nbsp;`;
                    }
                    t.id = q.id;
                    sizes[t.size].push(t);
                }
            }
            $("#size-pick").html(txt);
            setTimeout(function () {
                $("#size-pick .size:first-child").click();
            },50);
            // $("#size-pick .size").bind('click.select',function () {
            //     $("#size-pick .size").removeClass('active');
                let colorNames  = {};
                try {
                    colorNames = JSON.parse($("#colors").val());
                } catch {
                }

                // $(this).addClass('active');
                let colors = sizes[$(this).data('id')];
                txt = '';
                let cl = '';
                for( const c of colors) {
                    cl = colorNames[c.color];
                    // console.log(c.color,colorNames);
                    txt += `<div data-id="${c.id}"
                                            data-price="${c.price}"
                                                        data-count="${c.count}"
                                                         data-image="${c.image}"
                                                         class="color">
                                                         <div class="cl" style="background: ${c.color}" ></div>
                                                         <span>${cl}</span>
                                                         </div>`;
                }

                $(".color-pick").html(txt);
                setTimeout(function () {
                    $(".color-pick .color:first-child").click();
                },50);
                $(".color-pick .color").bind('click.sel',function () {
                    $('.xzoom-thumbs a').eq($(this).data('image')).click();
                    $(".color-pick .color").removeClass('active');
                    $(this).addClass('active');
                    $("#qn").val($(this).data('id'));
                    $("#last-pricex").text(commafy($(this).data('price')));
                    $("#counting").text($(this).data('count'));
                    $(".product-count").attr('max',$(this).data('count')).val(1);
                });
            // });

        }
    } catch (e) {
        // console.log('size err',e.message);
    }


// prticale
    try {
        let prtcl = document.getElementById('particle')

        function setParticles(num) {
            for (let i = 0; i < num; i++) {
                let prt = document.createElement('div')
                prt.setAttribute('class', 'particles')
                prt.style.left = 100 * Math.random() + "%"
                prt.animate([{
                    transform: 'translate(-200px, 0) scale(' + Math.random() * 10 + ')'
                }, {
                    transform: 'translate(' + Math.random() * 500 + 'px, 112vh) scale(' + Math.random() * 2 + ')',
                    background: '#ff00ff',
                    boxShadow: '0 0 4px #ff00ff, 0 0 8px #ff00ff',
                    opacity: Math.random() * 1.4
                }], {
                    duration: Math.random() * 400 + 8000,
                    delay: -i * 100,
                    iterations: Infinity
                })
                prtcl.appendChild(prt)
            }
        }

        setParticles(100)
    } catch (e) {
        // console.log(e.message);
    }

    setTimeout(function () {
        $(".x-side-menu #searching").attr('id','sub-search');
        $("#sub-search").keyup(function () {
            let q = $(this).val();
            if  (q.length < 3){
                $(".x-side-menu .list-group-item").remove();
                return false;
            }
            axios.get($(this).data('ajax') + '?q=' + q).then(function (e) {
                if (!e.data.OK) {
                    window.alertify.error(e.data.err);
                } else {
                    $(".x-side-menu .list-group-item").remove();
                    // text += '<ul class="list-group">';
                    let text = '';
                    for (const p of e.data.data) {
                        text += '<li class="list-group-item">';
                        text += `<a href="${p.link}">`;
                        text += `<img src="${p.image}" alt="product image">`
                        text += `<span>${p.name}</span> <hr>`
                        text += `<b>${p.price}</b>`
                        text += '</a>';
                        text += '</li>';
                    }
                    text += '<li class="list-group-item">';
                    text += '<a href="' + $(self).data('url') + '?q=' + q + '">';
                    text += 'جستجو موارد بیشتر :';
                    text += q;
                    text += '</a>';
                    text += '</li>';
                    // text += '</ul>';
                    $(".x-side-menu").append(text);

                }
            });
        });
    },1000);

    $("#card table th").each(function (k,e) {
        $("#card td:nth-child("+(k+1)+")").attr('data-before',$(e).text().trim());
    })


});


