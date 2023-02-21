window.sel2 = require('select2/dist/js/select2.min');
jQuery(function () {
    // document.body.style.zoom = (window.innerWidth / window.outerWidth)

    try {
        // window.sel2(jQuery);
        $('.sel2').select2();
    } catch (e) {
        console.log('sel2 error', e.message);
    }

    group = $(".srt").sortable({
        group: 'sorting',
        onDrop: function ($item, container, _super) {
            var data = group.sortable("serialize").get()[0];
            var jsonString = JSON.stringify(data);
            $("#sort-result").val(jsonString);
            _super($item, container);
        }
    });
});

