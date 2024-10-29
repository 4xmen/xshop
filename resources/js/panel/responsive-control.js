const responsiveControl = function () {
    let vpw = document.querySelector('body').clientWidth; // view port width

    if (document.querySelectorAll('.table-list').length > 0) {
        if (vpw  > 620) {
            document.querySelectorAll('.table-list span.th')?.forEach(function (el) {
                el.remove();
            })
        } else {
            if (document.querySelectorAll('.table-list span.th')?.length === 0) {

                document.querySelectorAll('.table-list')?.forEach(function (table) {

                    // console.log(table);
                    // Get all the header cells
                    const headers = Array.from(table.querySelectorAll('th')).map(th => th.textContent.trim());

                    // Get all the rows in the table, excluding the header row
                    const rows = table.querySelectorAll('tr');

                    rows.forEach(function (row) {
                        const cells = row.querySelectorAll('td');

                        cells.forEach(function (cell, index) {
                            const headerText = headers[index]; // Get the corresponding header for this cell
                            if (headerText.trim() != ''){
                                cell.innerHTML = `<span class="th float-start"> ${headerText}: </span> ${cell.innerHTML}`; // Update the cell content
                            }
                        });
                    });
                });


            }
        }
    }
};
window.addEventListener('resize', responsiveControl);
window.addEventListener('load', responsiveControl)
