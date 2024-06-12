document.addEventListener('readystatechange',function () {
    let dirx = 'ltr';
    document.querySelectorAll('.ckeditorx')?.forEach(function (el) {
        CKEDITOR.replace(el.getAttribute('name'), {
            filebrowserUploadUrl: xupload,
            filebrowserUploadMethod: 'form',
            contentsLangDirection: dirx,
            skin: 'moono-dark',
        });

        // WIP: need font and color like website
        CKEDITOR.addCss('.cke_editable { background-color: #212529; color: white }');

    });
});
