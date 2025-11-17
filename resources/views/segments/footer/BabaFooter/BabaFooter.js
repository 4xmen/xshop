// Expandable sections for .baba-list (≤768 px)
document.addEventListener('DOMContentLoaded', () => {
    const sel = '.baba-list';
    const heads = document.querySelectorAll(`${sel} h3.toggle`);

    heads.forEach(h => {
        h.innerHTML += '<i class="ri-arrow-down-s-line"></i>';
        h.addEventListener('click', () => {
            const ul = h.nextElementSibling;
            if (ul && window.innerWidth <= 767) ul.classList.toggle('active');
        });
    });

    // Reset on resize
    window.addEventListener('resize', () => {
        const uls = document.querySelectorAll(`${sel} ul.content`);
        if (window.innerWidth > 767) {
            uls.forEach(u => { u.classList.remove('active'); u.style.display = 'block'; });
        } else {
            uls.forEach(u => { u.classList.remove('active'); u.style.display = 'none'; });
        }
    });
});
