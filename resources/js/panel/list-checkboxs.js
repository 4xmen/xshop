function clearSelection()
{
    if (window.getSelection) {window.getSelection().removeAllRanges();}
    else if (document.selection) {document.selection.empty();}
}

window.addEventListener('load',function () {
    let chkall = document.querySelectorAll(".chkall");

    document.querySelector('#toggle-select').addEventListener('click',function () {
        let checkboxes = document.querySelectorAll(".chkbox");
        checkboxes.forEach(function(checkbox) {
            if (!checkbox.checked){
                checkbox.checked = true;
                checkbox.setAttribute("checked", "");
            }else{
                checkbox.checked = false;
                checkbox.removeAttribute("checked");
            }
        });
    });
// Attach an event listener for "change" and "click" events
    chkall.forEach(function(chkall) {
        chkall.addEventListener("change", handleCheckboxChange);
        chkall.addEventListener("click", handleCheckboxChange);
    });

    function handleCheckboxChange() {
        let isChecked = this.checked;
        let table = this.closest("table");

        if (isChecked) {
            // Check all checkboxes in the table
            let checkboxes = table.querySelectorAll(".chkbox");
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = true;
                checkbox.setAttribute("checked", "");
            });
        } else {
            // Uncheck all checkboxes in the table
            let checkboxes = table.querySelectorAll(".chkbox");
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
                checkbox.removeAttribute("checked");
            });
        }
    }



    // select with shift button
    const chkboxes = document.querySelectorAll('.chkbox');
    let lastChecked = null;

    chkboxes.forEach(chkbox => {
        chkbox.addEventListener('click', handleCheckboxClick);
        chkbox.parentNode.querySelector('label').addEventListener('click', handleCheckboxClick);
    });

    function handleCheckboxClick(e) {
        clearSelection();

        let self = this;
        if (e.target.tagName === 'LABEL'){
            self = e.target.parentNode.querySelector('input');
        }
        if (!lastChecked) {
            lastChecked = self;
            return;
        }

        if (e.shiftKey) {
            const start = Array.from(chkboxes).indexOf(self);
            const end = Array.from(chkboxes).indexOf(lastChecked);
            const range = Array.from(chkboxes).slice(Math.min(start, end) + 1, Math.max(start, end) );

            range.forEach(chkbox => {
                chkbox.checked = lastChecked.checked;
            });

        }

        lastChecked = self;

    }

});

