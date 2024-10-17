

window.findUrl = function (name, item = null) {
    for (var i = 0; i < window.routesList.length; i++) {
        if (window.routesList[i].name === name) {
            if (item != null) {
                return window.routesList[i].url.split('{item}').join(item);
            } else {
                return window.routesList[i].url;
            }
        }
    }
    return null;
}



document.addEventListener('DOMContentLoaded', () => {


    document.querySelectorAll('.delete-confirm')?.forEach(function (el) {
        el.addEventListener('click', function (e) {
            if (!confirm(window.TR.deleteConfirm)) { // WIP Need to translate
                e.preventDefault();
            }
        });
    });

    document.querySelectorAll('[data-open-file]')?.forEach(function (el) {
        el.addEventListener('click', function () {
            document.querySelector(this.getAttribute('data-open-file')).click();
        });
    });
});
