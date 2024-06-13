document.addEventListener('click', function(e) {
    if (e.target.classList.contains('delete-confirm')) {
        if (!confirm('Are you sure you want to delete this item?')) { // WIP Need to translate
           e.preventDefault();
        }
    }
});

document.querySelectorAll('.delete-confirm')?.forEach(function (el) {
  el.addEventListener('click',function (e) {
      if (!confirm('Are you sure you want to delete this item?')) { // WIP Need to translate
          e.preventDefault();
      }
  });
})
