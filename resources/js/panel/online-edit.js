document.addEventListener('DOMContentLoaded', function () {


    document.querySelectorAll('.ai-confirm')?.forEach(function (el) {
        el.addEventListener('click', function (e) {
            if (!confirm(window.TR.aiConfirm)) {
                e.preventDefault();
            }
        });
    });


    document.querySelector('#qTranslate')?.addEventListener('keyup', function (e) {
        const q = e.target.value;
        document.querySelectorAll('.tr-content').forEach(function (el) {
            const content = el.getAttribute('data-content');
            if (content.toLowerCase().indexOf(q.toLowerCase()) === -1) {
                el.style.display = 'none';
            } else {
                el.style.display = 'table-row';
            }
        });
    });

    document.querySelector('#add-translate') ?.addEventListener('click', function () {
        const lastRow = document.querySelector('#translate-table tr:last-child');
        const tr = lastRow.cloneNode(true);

        tr.querySelector('td:first-child input').value = '';
        tr.querySelector('td:first-child input').removeAttribute('readonly')
        tr.querySelector('td:last-child input').removeAttribute('readonly')
        tr.querySelector('td:last-child input').value = '';

        document.querySelector('#translate-table tbody').appendChild(tr);
    });


    document.querySelector('#sort-translate')?.addEventListener('click', function () {
        // 1. Get the table body element
        const tbody = document.querySelector('#translate-table tbody');

        // 2. Collect only the rows that should be sorted (e.g. those with class "tr-content")
        const rows = Array.from(tbody.querySelectorAll('tr.tr-content'));

        // 3. Sort rows based on the value of the input in the first cell
        rows.sort((a, b) => {
            const textA = a.querySelector('td:last-child input').value.trim();
            const textB = b.querySelector('td:last-child input').value.trim();
            // localeCompare handles alphabetical order and case insensitivity
            return textA.localeCompare(textB, undefined, {sensitivity: 'base'});
        });

        // 4. Re-append the sorted rows back into the tbody
        rows.forEach(row => tbody.appendChild(row));
    });

    //  Update row data-content when any input changes
    document.querySelector('#translate-table tbody')?.addEventListener('input', e => {
        const row = e.target.closest('tr.tr-content');
        if (!row) return;
        const key = row.querySelector('td:last-child input').value.trim();
        const val = row.querySelector('td:first-child input').value.trim();
        row.setAttribute('data-content', `${key} ${val}`);
    });

//  Remove readonly on double-click of readonly inputs
    document.querySelector('#translate-table tbody')?.addEventListener('dblclick', e => {
        const inp = e.target;
        if (inp.tagName === 'INPUT' && inp.hasAttribute('readonly')) {
            inp.removeAttribute('readonly');
        }
    });

    document.querySelector('#online-edit-translate')?.addEventListener('submit', function (e) {
            const rows = this.querySelectorAll('tr.tr-content');
            const data = {};

            rows.forEach(row => {
                const val = row.querySelector('td:first-child input').value;
                const key = row.querySelector('td:last-child input').value;
                if (key) data[key] = val;
            });

            this.querySelector('input[name="json"]').value = JSON.stringify(data, null, 4);
            // allow form to submit
            if (data.length < 1){
                e.preventDefault();
            }
        });

});
