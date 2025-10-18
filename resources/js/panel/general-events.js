

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

// copy text to clipboard, using the modern Clipboard API when available
function copyToClipboard(text) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        return navigator.clipboard.writeText(text);
    }
    // fallback for older browsers
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    document.body.appendChild(textarea);
    textarea.select();
    try {
        document.execCommand('copy');
        return Promise.resolve();
    } finally {
        document.body.removeChild(textarea);
    }
}




document.addEventListener('DOMContentLoaded', () => {


    // attach click listeners to all copy buttons inside elements with class "copiable"

    const containers = document.querySelectorAll('.copiable');

    containers.forEach(container => {
        const btn = container.querySelector('.copy-btn');
        const input = container.querySelector('input');

        if (!btn || !input) return;

        btn.addEventListener('click', async () => {
            try {
                await copyToClipboard(input.value);
               $toast.success(window.TR.copied);
            } catch (err) {
                console.error('copy failed', err);
            }
        });
    });

    document.querySelectorAll('.delete-confirm')?.forEach(function (el) {
        el.addEventListener('click', function (e) {
            if (!confirm(window.TR.deleteConfirm)) {
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
