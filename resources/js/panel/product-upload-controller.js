var isW8 = false;
let uploadFormData = [];
let xTimer;
window.noSubmit = false;

function previewImage(input, i) {
    try {
        const oFReader = new FileReader();
        oFReader.readAsDataURL(input);
        oFReader.onload = function (oFREvent) {
            const img = oFREvent.target.result;
            const uploadingImages = document.querySelector('#uploading-images');
            const newDiv = document.createElement('div');
            newDiv.dataset.id = i;
            newDiv.className = 'col-xl-3 col-md-4 border p-3';
            newDiv.innerHTML = `
        <div class="img-preview" style="background-image: url('${img}')"></div>
        <div class="btn btn-danger upload-remove-image d-block">
          <span class="ri-close-line"></span>
        </div>
      `;
            uploadingImages.appendChild(newDiv);
        };

        if (xTimer !== undefined) {
            clearTimeout(xTimer);
        }

        xTimer = setTimeout(() => {
            document.querySelectorAll('.img-preview').forEach(el => {
                el.style.height = `${el.offsetWidth}px`;
            });
            window.dispatchEvent(new Event('resize'));
        }, 300);
    } catch (e) {
        console.error('Error in previewImage:', e);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const uploadingImages = document.querySelector('#uploading-images');
    const uploadDragDrop = document.querySelector('#upload-drag-drop');
    const uploadImageSelect = document.querySelector('#upload-image-select');
    const indexImage = document.querySelector('#index-image');

    document.querySelector('.product-form')?.addEventListener('submit', function(e) {

        e.preventDefault();
        if (isW8 || window.noSubmit) {
            return false;
        }

        const formData = new FormData(this);
        let j = 0;
        for (const f of uploadFormData) {
            if (uploadFormData.length == j) {
                break;
            }
            j++;
            try {
                if (f.size === undefined) {
                    continue;
                }
            } catch (e) {
                console.log(e.message);
                continue;
            }
            console.log('x',f);
            formData.append('image[]', f);
        }

        const submitButtons = document.querySelectorAll("[type='submit']");
        submitButtons.forEach(button => {
            button.disabled = true;
            button.classList.add('w8');
        });

        isW8 = true;
        const url = this.getAttribute('action');


        axios({
            method: 'post',
            url: url,
            data: formData,
            headers: {'Content-Type': 'multipart/form-data'}
        }).then(res => {
            submitButtons.forEach(button => {
                button.disabled = false;
                button.classList.remove('w8');
            });
            isW8 = false;

            if (res.data.OK) {
                if (res.data.url !== undefined) {
                    window.location.href = res.data.url;
                } else {
                    if (res.data.link !== undefined) {
                        this.setAttribute('action', res.data.link);
                    }
                    window.redirect = currentEditLink + res.data.data.slug;
                    this.setAttribute('action', currentUpdateLink + res.data.data.slug)
                    $toast.info(res.data.message);
                    window.store.dispatch('updateQuantities',res.data.data.qidz);
                }
            }
        }).catch(error => {
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            submitButtons.forEach(button => {
                button.disabled = false;
                button.classList.remove('w8');
            });
            isW8 = false;

            for (let i in error.response.data.errors) {
                document.getElementById(i)?.classList.add('is-invalid');
                for (const err of error.response.data.errors[i]) {
                    $toast.error(err);
                    // console.log(err);
                }
            }
            $toast.error('Error:' +error.response.status);
        });
    });
    uploadingImages?.addEventListener('dblclick', (e) => {
        const imageIndex = e.target.closest('.image-index');
        if (imageIndex) {
            document.querySelectorAll('.indexed').forEach(el => el.classList.remove('indexed'));
            imageIndex.classList.add('indexed');
            indexImage.value = imageIndex.dataset.key;
        }
    });

    document.querySelectorAll('.img-preview').forEach(el => {
        el.style.height = `${el.offsetWidth}px`;
    });

    uploadDragDrop?.addEventListener('click', () => {
        uploadImageSelect.click();
    });

    uploadImageSelect?.addEventListener('change', () => {
        for (const file of uploadImageSelect.files) {
            console.log(file);
            uploadFormData.push(file);
            previewImage(file, uploadFormData.length);
        }
    });

    document.addEventListener('click', (e) => {
        if (e.target.closest('.upload-remove-image')) {
            const parentCol = e.target.closest('.col-md-4');
            const dataId = parentCol.dataset.id;
            delete uploadFormData[dataId - 1];
            parentCol.style.transition = 'opacity 400ms';
            parentCol.style.opacity = '0';
            setTimeout(() => parentCol.remove(), 400);
        }
    });

    uploadDragDrop?.addEventListener('dragover', (e) => {
        e.preventDefault();
        e.stopPropagation();
        uploadDragDrop.classList.add('active');
    });

    ['dragenter', 'dragstart'].forEach(eventName => {
        uploadDragDrop?.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            uploadDragDrop.classList.add('active');
        });
    });

    ['dragleave', 'dragend'].forEach(eventName => {
        uploadDragDrop?.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            uploadDragDrop.classList.remove('active');
        });
    });

    uploadDragDrop?.addEventListener('drop', (e) => {
        uploadDragDrop.classList.remove('active');
        if (e.dataTransfer && e.dataTransfer.files.length) {
            e.preventDefault();
            e.stopPropagation();

            for (const f of e.dataTransfer.files) {
                previewImage(f, uploadFormData.length);
                uploadFormData.push(f);
            }
        }
    });
});
