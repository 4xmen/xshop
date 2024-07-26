document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.comment-reply')?.forEach(function (el) {
        el.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            document.querySelector('#parent_id').value = id;
            document.querySelectorAll('.simple-single-comment')?.forEach(function (el2) {
              el2.classList.remove('on-reply');
            });
            el.closest('.simple-single-comment').classList.add('on-reply')
        });
    })
});
