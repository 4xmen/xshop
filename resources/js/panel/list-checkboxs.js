function clearSelection() {
    if (window.getSelection) {
        window.getSelection().removeAllRanges();
    } else if (document.selection) {
        document.selection.empty();
    }
}


function serializeForm(selector) {
    let form = document.querySelector(selector);
    if (form == null) {
        return [];
    }
    let formData = new FormData(form);
    let serializedArray = [];

    formData.forEach(function (value, key) {
        serializedArray.push({
            name: key,
            value: value
        });
    });

    return serializedArray;
}

function handleCheckChange() {
    let frm = serializeForm('#main-form');
    let bi = document.querySelector('#bulk-idz');

    if (bi != null) {

        try {
            bi.innerHTML = '';
            for (const item of frm) {
                let n = document.createElement("input");
                n.name = item.name;
                n.value = item.value;
                n.type = 'hidden';
                bi.appendChild(n);
            }

            if (frm.length == 0) {
                document.querySelector('#bulk-from').style.maxHeight = '0';
            } else {
                document.querySelector('#bulk-from').style.maxHeight = '250px';
            }
        } catch (e) {
            console.log(e.message);
        }
    }


}

window.addEventListener('load', function () {
    let chkall = document.querySelectorAll(".chkall");

    if (chkall.length == 0) {
        return false;
    }
    let toggle = document.querySelector('#toggle-select');
    if (toggle != null) {
        toggle?.addEventListener('click', function () {
            let checkboxes = document.querySelectorAll(".chkbox");
            checkboxes.forEach(function (checkbox) {
                if (!checkbox.checked) {
                    checkbox.checked = true;
                    checkbox.setAttribute("checked", "");
                } else {
                    checkbox.checked = false;
                    checkbox.removeAttribute("checked");
                }
            });
            handleCheckChange();

        });
    }
// Attach an event listener for "change" and "click" events
    chkall.forEach(function (chkall) {
        chkall.addEventListener("change", handleCheckboxChange);
        chkall.addEventListener("click", handleCheckboxChange);
    });

    function handleCheckboxChange() {
        let isChecked = this.checked;
        let table = this.closest("table");

        if (isChecked) {
            // Check all checkboxes in the table
            let checkboxes = table.querySelectorAll(".chkbox");
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = true;
                checkbox.setAttribute("checked", "");
            });
        } else {
            // Uncheck all checkboxes in the table
            let checkboxes = table.querySelectorAll(".chkbox");
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
                checkbox.removeAttribute("checked");
            });
        }
        handleCheckChange();
    }


    // select with shift button
    const chkboxes = document.querySelectorAll('.chkbox');
    let lastChecked = null;

    chkboxes.forEach(chkbox => {
        chkbox.addEventListener('click', handleCheckboxClick);
        chkbox.parentNode.querySelector('label').addEventListener('click', handleCheckboxClick);
        chkbox.addEventListener('change', handleCheckChange);
    });

    function handleCheckboxClick(e) {
        clearSelection();

        let self = this;
        if (e.target.tagName === 'LABEL') {
            self = e.target.parentNode.querySelector('input');
        }
        if (!lastChecked) {
            lastChecked = self;
            return;
        }

        if (e.shiftKey) {
            const start = Array.from(chkboxes).indexOf(self);
            const end = Array.from(chkboxes).indexOf(lastChecked);
            const range = Array.from(chkboxes).slice(Math.min(start, end) + 1, Math.max(start, end));

            range.forEach(chkbox => {
                chkbox.checked = lastChecked.checked;
            });

        }

        handleCheckChange();
        lastChecked = self;

    }

    handleCheckChange();
});

