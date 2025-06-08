document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.comment-reply')?.forEach(function (el) {
        el.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            document.querySelector('#parent_id').value = id;
            document.querySelectorAll('.faraz-single-comment')?.forEach(function (el2) {
                el2.classList.remove('on-reply');
            });
            el.closest('.faraz-single-comment').classList.add('on-reply')
        });
    });
    document.querySelector('#faraz-more')?.addEventListener('click',function (e) {
        e.preventDefault();
      this.parentNode.style.display = 'none';
      document.querySelector('.read-more').style.maxHeight = '50vh';
      setTimeout(function () {
          document.querySelector('.read-more').style.overflowY = 'auto';
      },500);
    });
});
