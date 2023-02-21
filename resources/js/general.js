jQuery(function () {
    $("nav [href='" + window.location.href + "']").closest('li').addClass('current');
    // console.log(
       setTimeout(function () {
           if ($("nav .current").closest('.main-nav').find('> a').attr('href') == undefined){
               $("nav .current").closest('.main-nav').find('> a').click();
           }
           if ($("nav .current").parent().parent().hasClass('rvnm-expandable')){
               $("nav .current").parent().parent().find('> a').click();
           }
       },500);

       $("#menu-manage li").bind('dblclick',function () {
         if (confirm('Are sure?')){
             $(this).remove();
         }
       });
    // );
    // $("nav .current").closest('li').click();
});
