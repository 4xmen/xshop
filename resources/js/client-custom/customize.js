var onEdit = '';
document.querySelector('#do-edit')?.addEventListener('click', function () {
    this.style.display = 'none';
    let editable = document.createElement('div');
    editable.setAttribute('id', 'customizable');
    editable.innerHTML = '<i class="ri-edit-2-line"></i> <b></b>';
    document.body.appendChild(editable);
    document.querySelectorAll('.live-setting')?.forEach(function (el) {
        el.addEventListener('mouseenter', function () {

            setTimeout(() => {
                let rect = el.getBoundingClientRect();
                onEdit = this.getAttribute('data-live');
                document.querySelector('#customizable b').innerText = onEdit;
                document.querySelector('#customizable').style.top = (window.scrollY + rect.top + 5) + 'px';
            }, 50);
        });
        el.addEventListener('mouseleave', function () {

            console.log(this.getAttribute('data-live'));
        });
    });
    editable.addEventListener('click', function () {
        if (document.querySelector('#customize-modal') == null) {

            let custModal = document.createElement('div');
            custModal.setAttribute('id', 'customize-modal');
            custModal.innerHTML = '<iframe></iframe>';
            document.body.appendChild(custModal);
            custModal.addEventListener('click', function (e) {
                if (e.target == this) {
                    window.location.reload();
                }
            });
        } else {
            document.querySelector('#customize-modal').style.display = 'block';
        }

        document.addEventListener('keyup',function (e) {
            if (e.code == 'Escape'){
                window.location.reload();
            }
        });

        document.querySelector('#customize-modal iframe').setAttribute('src', document.querySelector('#live-url').value + onEdit);

    });
});
