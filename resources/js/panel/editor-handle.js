window.addEventListener('load', function () {
    let dirx = 'ltr';
    let editors = {};
    document.querySelectorAll('.ckeditorx')?.forEach(function (el) {
        editors[el.getAttribute('name')] = CKEDITOR.replace(el.getAttribute('name'), {
            filebrowserUploadUrl: xupload,
            filebrowserUploadMethod: 'form',
            contentsLangDirection: dirx,
            skin: 'moono-dark',
        });

        CKEDITOR.addCss('.cke_editable { background-color: ' + website_bg + '; color: ' + website_text_color + ' ; font-family: ' + website_font + ' }');
        editors[el.getAttribute('name')].on('change', function (evt) {
            el.value = evt.editor.getData();
        });
    });
});
