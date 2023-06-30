
    $(function () {
        $('.slider .owl-carousel').owlCarousel({
            rtl:true,
            loop:true,
            margin:15,
            autoplay:true,
            nav:true,
            responsive:{
                0:{
                    items:2
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        });
    })

