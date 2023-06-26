// back to top btn
$('.backtop-btn').click(function(){
    $('html, body').animate({ scrollTop: 0 }, 'slow');
    return false;
});

/* pre loader */
$(window).on('load', function () {
    $('#preloader').delay(350).fadeOut('slow');
    $('body').delay(350).css({ 'overflow': 'visible' });
})
