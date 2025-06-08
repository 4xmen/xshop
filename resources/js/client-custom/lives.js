let defSearchText = '';
window.addEventListener('load', function () {
    defSearchText = document.querySelector('#live-search-data').innerHTML;
    document.querySelectorAll('.live-card-show')?.forEach(function (el) {
        el.addEventListener('click', async function (e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');
            let response = await axios.get(url);
            document.querySelector('#live-card-list').innerHTML = response.data;
            document.querySelector('#live-card-modal').style.display = 'block';
        });
    });

    document.querySelector('#live-card-modal').addEventListener('click', function (e) {
        if (e.target == this) {
            document.querySelector('#live-card-modal').style.display = 'none';
        }
    });
});

document.querySelectorAll('.live-search')?.forEach(function (el) {
  el.addEventListener('focus', function () {
        const rect = this.getBoundingClientRect();
        const scrollTop = window.scrollY || document.documentElement.scrollTop; // Get the current scroll position
        const scrollLeft = window.scrollX || document.documentElement.scrollLeft; // Get the current scroll position

        document.querySelector('#live-search-content').style.left = (rect.left + scrollLeft) + 'px'; // Adjust left position
        document.querySelector('#live-search-content').style.top = (rect.bottom + scrollTop) + 'px'; // Adjust top position
        document.querySelector('#live-search-content').style.width = rect.width + 'px';
        document.querySelector('#live-search-content').style.display = 'block';
    })
});



document.querySelectorAll('.live-search')?.forEach(function (el) {
  el.addEventListener('keyup', async function (e) {

      if (e.code == 'Escape'){
          document.querySelector('#live-search-content').style.display = 'none';
          return;
      }else{
          document.querySelector('#live-search-content').style.display = 'block';
      }
      if (this.value.length > 3){
          document.querySelector('#search-ajax-loader').style.display = 'inline-block';
          const url = this.closest('form').getAttribute('action');
          let response = await axios.post(url,{q: this.value});
          document.querySelector('#live-search-data').innerHTML = response.data ;
          document.querySelector('#search-ajax-loader').style.display = 'none';
      }else{
          document.querySelector('#live-search-data').innerHTML = defSearchText;
      }
  })
});

document.querySelectorAll('.live-search')?.forEach(function (el) {
  el.addEventListener('blur',  function () {
      setTimeout(function () {
          document.querySelector('#live-search-content').style.display = 'none';
      },500);
  });

})
