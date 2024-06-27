document.addEventListener('DOMContentLoaded', function () {
    // Get all section group items
    let sectionGroupItems = document.querySelectorAll('.section-group-item');

    // Get all sections
    let sections = document.querySelectorAll('#setting-sections section');

    // Hide all sections initially
    sections?.forEach(section => {
        section.style.display = 'none';
    });


    // Show/hide sections on click
    sectionGroupItems?.forEach(item => {
        item.addEventListener('click', function (event) {
            try {

                event.preventDefault();
                let targetId = this.getAttribute('href').slice(1);
                sections.forEach(section => {
                    if (section.id === targetId) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
                sectionGroupItems.forEach(link => {
                    link.classList.remove('active');
                });
                this.classList.add('active');

            } catch (e) {
                console.log(e.message);
            }

        });
    });

    // Show section based on hash in URL
    let hash = window.location.hash.slice(1);
    if (hash) {
        sections.forEach(section => {
            if (section.id === hash) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });
    }


    try {
        // Show the first section on page load
        document.querySelector('.section-group-item').dispatchEvent(new Event('click'));
    } catch (e) {
    }

});
