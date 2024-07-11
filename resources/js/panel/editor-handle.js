window.addEventListener('load', function () {
    let dirx = document.querySelector('#panel-dir').value;
    let editors = {};
    document.querySelectorAll('.ckeditorx')?.forEach(function (el) {

        const currentDir = el.getAttribute('dir');
        let finalDir = dirx;
        if (currentDir != null){
            finalDir = currentDir;
        }
        editors[el.getAttribute('name')] = CKEDITOR.replace(el.getAttribute('name'), {
            filebrowserUploadUrl: xupload,
            filebrowserUploadMethod: 'form',
            contentsLangDirection: finalDir,
            skin: 'moono-dark',
        });

        CKEDITOR.addCss('.cke_editable { background-color: ' + website_bg + '; color: ' + website_text_color + ' ; font-family: ' + website_font + ' }');
        editors[el.getAttribute('name')].on('change', function (evt) {
            el.value = evt.editor.getData();
        });
    });
});
