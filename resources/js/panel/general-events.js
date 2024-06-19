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
});


window.findUrl = function (name,item = null) {
    for (var i = 0; i < window.routesList.length; i++) {
        if (window.routesList[i].name === name) {
            if (item != null){
                return window.routesList[i].url.split('{item}').join(item);
            }else{
                return window.routesList[i].url;
            }
        }
    }
    return null;
}



