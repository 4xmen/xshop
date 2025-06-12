document.addEventListener('DOMContentLoaded', function () {

    document.querySelector('#share-modal')?.addEventListener('click', function (e) {
        if (e.target == this) {
            document.querySelector('#share-modal').style.display = 'none';
        }
    });
    document.querySelector('#share-close')?.addEventListener('click', function () {
        document.querySelector('#share-modal').style.display = 'none';
    });

    document.querySelector('#share-copy')?.addEventListener('click', function () {
        const copyText = document.getElementById("share-link");

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);

        document.querySelector('#share-modal').style.display = 'none';

        setTimeout(function () {
            $toast.success("Copied");
        }, 400);
    });


    document.querySelectorAll('.share-btn')?.forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector('#share-modal').style.display = 'flex';
            const img = document.querySelector('#page-image');
            if (img) {
                document.querySelector('#share-image').setAttribute('src', img.value);
            }
        });
    });
});


