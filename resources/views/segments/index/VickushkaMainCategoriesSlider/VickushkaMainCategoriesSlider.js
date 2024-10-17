document.addEventListener('DOMContentLoaded',function () {
    document.querySelectorAll('.v-main-category')?.forEach(function (el) {
        el.addEventListener('click',function () {
          document.querySelectorAll('.v-item').forEach(function (elm) {
            elm.style.display = 'none';
          });
            // Get the element to be displayed
            const targetId = el.getAttribute('data-id');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                targetElement.style.display = 'block';

                // Scroll to the element
                targetElement.scrollIntoView({
                    behavior: 'smooth', // Smooth scroll effect
                    block: 'start' // Scroll to the top of the element
                });
            }
        });
    });
});
