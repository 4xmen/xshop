document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.edit-category-btn')?.forEach(function (el) {
        el.setAttribute('href', '#edit-category');
        el.addEventListener('click', function (e) {
            e.preventDefault();
            let id = this.closest('tr').querySelector('input.chkbox').getAttribute('value');
            const url = document.querySelector('#category-edit-url').value + id;
            document.querySelector('#iframe-modal iframe').setAttribute('src', url);
            document.querySelector('#iframe-modal').style.display = 'block';

        });
    });
    document.querySelectorAll('.edit-group-btn')?.forEach(function (el) {
        el.setAttribute('href', '#group-category');
        el.addEventListener('click', function (e) {
            e.preventDefault();
            let id = this.closest('tr').querySelector('input.chkbox').getAttribute('value');
            const url = document.querySelector('#group-edit-url').value + id;
            document.querySelector('#iframe-modal iframe').setAttribute('src', url);
            document.querySelector('#iframe-modal').style.display = 'block';

        });
    });

    document.querySelector('#iframe-modal')?.addEventListener('click', function (e) {
        if (e.target == this) {
            this.style.display = 'none';
        }
    });

    document.querySelector('#categories-save-btn')?.addEventListener('click', function (e) {
        e.preventDefault();


        const url = document.querySelector('#ajax-sync-form').getAttribute('action');

        // Serialize the form data
        const formData = new FormData();
        const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');

        checkboxes.forEach(checkbox => {
            formData.append('cat[]', checkbox.value);
        });

        // Optional: log serialized data for debugging
        for (const [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        // Get the URL from the form's action attribute

        // Make the AJAX POST request using Axios
        axios.post(url, formData)
            .then(response => {
                // Handle success
                if (response.data.OK == true){
                    $toast.success(response.data.message);
                }else{

                    $toast.error(response.data.error);
                }
            })
            .catch(error => {
                // Handle error
                $toast.error( error);
            });

    });

});
