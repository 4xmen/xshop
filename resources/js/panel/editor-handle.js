window.addEventListener('load',function () {
    let dirx = 'ltr';
    let editors = {};
    document.querySelectorAll('.ckeditorx')?.forEach(function (el) {
        editors[el.getAttribute('name')] =  CKEDITOR.replace(el.getAttribute('name'), {
            filebrowserUploadUrl: xupload,
            filebrowserUploadMethod: 'form',
            contentsLangDirection: dirx,
            skin: 'moono-dark',
        });

        // WIP: need font and color like website
        CKEDITOR.addCss('.cke_editable { background-color: #212529; color: white }');
        editors[el.getAttribute('name')].on('change', function (evt) {
            el.value = evt.editor.getData();
        });
    });
});
