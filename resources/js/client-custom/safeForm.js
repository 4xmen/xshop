window.addEventListener('load',function () {

  setTimeout(()=>{
      document.querySelectorAll('.safe-form')?.forEach(function (el) {

          const  url = el.querySelector('.safe-url').getAttribute('data-url');
          el.setAttribute('action',url);
      })
  },1220);

})
