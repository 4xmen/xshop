$(document).ready(function(){
    $('.navbarx-toggler').click(function(){
        $('.navbarx-collapse').slideToggle(300);
    });

    smallScreenMenu();
    let temp;
    function resizeEnd(){
        smallScreenMenu();
    }

    $(window).resize(function(){
        clearTimeout(temp);
        temp = setTimeout(resizeEnd, 100);
        resetMenu();
    });
    var btn = $('#go-top');
    $(window).scroll(function () {
        if ($(window).scrollTop() > 150 && $(window).width() > 990){
            $('.main-wrapper').addClass('fixed');
        }else{
            $('.main-wrapper').removeClass('fixed');
        }

        if ($(window).scrollTop() > 150 && $(window).width() < 990){
            $('#top').addClass('fixed');
        }else{
            $('#top').removeClass('fixed');
        }

        if ($(window).scrollTop() > 300) {
            btn.addClass('show');
        } else {
            btn.removeClass('show');
        }
    });
});


const subMenus = $('.sub-menu');
const menuLinks = $('.menu-link');

function smallScreenMenu(){
    if($(window).innerWidth() <= 992){
        $(".navbarx-nav > li a").bind('click',function (e) {
            e.preventDefault();
          return false;
        });
        menuLinks.each(function(item){
            $(this).click(function(){
                $(this).next().slideToggle();
            });
        });
    } else {
        menuLinks.each(function(item){
            $(this).off('click');
        });
    }
}

function resetMenu(){
    if($(window).innerWidth() > 992){
        subMenus.each(function(item){
            $(this).css('display', 'none');
        });
    }
}
