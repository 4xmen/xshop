window.addEventListener('load', function () {
    window.addEventListener('scroll',function (e) {
        if (window.scrollY > 100){
            document.querySelector('.SarvMenu').classList.add('fixed');
        }else{
            document.querySelector('.SarvMenu').classList.remove('fixed');
        }
    });

    document.querySelector('#sarv-toggle').addEventListener('click',function () {
        document.querySelector('#sarv-responsive-menu').style.display = 'flex';
    });

    document.querySelector('#sarv-responsive-menu').addEventListener('click',function (e) {
      if (e.target == this){
          document.querySelector('#sarv-responsive-menu').style.display = 'none';
      }
    })
})
