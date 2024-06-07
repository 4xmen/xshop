document.addEventListener('click', function(e) {
    if (e.target.classList.contains('delete-confirm')) {
        if (!confirm('Are you sure you want to delete this item?')) { // WIP Need to translate
           e.preventDefault();
        }
    }
});
