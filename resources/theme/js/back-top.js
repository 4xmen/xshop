// back to top btn
$('.backtop-btn').click(function () {
    $('html, body').animate({scrollTop: 0}, 'slow');
    return false;
});

/* pre loader */
$('#preloader').delay(450).fadeOut('slow');
$('body').delay(450).css({'overflow': 'visible'});
