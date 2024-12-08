const scrollBreakpoint = window.innerHeight * 0.2;
let fixmenu = function () {
  try {
      if (window.scrollY > scrollBreakpoint){
          document.querySelector('.HomayonMenu').classList.add('fix');
          document.querySelector('.HomayonMenu').querySelector('.homayon-middle').classList.remove('container');
      }else{
          document.querySelector('.HomayonMenu').classList.remove('fix')
          document.querySelector('.HomayonMenu').querySelector('.homayon-middle').classList.add('container');
      }
  } catch {
  }

}
window.addEventListener('scroll',fixmenu);


fixmenu();
const toggleSideMenu = function (e) {
    e.preventDefault();
    if (document.querySelector('.homayon-resp-menu').style.display == 'none'){
        document.querySelector('.homayon-resp-menu').style.display = 'block';
    }else{
        document.querySelector('.homayon-resp-menu').style.display = 'none';
    }
};
document.addEventListener('DOMContentLoaded',function () {
    document.querySelector('#homa-toggle-menu')?.addEventListener('click',toggleSideMenu);
});

