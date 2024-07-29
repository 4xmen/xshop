
document.addEventListener('DOMContentLoaded', function () {

    const aparatList = document.querySelector('.aparat-list');
    let isScrolling = false;
    let startX;
    let scrollLeft;
    const scrollSpeed = 150; // Adjust this value to change scroll speed
    let moveInterval;
    let me;

    document.querySelectorAll('.aparat-link')?.forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector('#aparat-main-image').setAttribute('src', this.getAttribute('href'));
        });
    });


    aparatList.addEventListener('mousemove', (e) => {
        me = e;
    });

    aparatList.addEventListener('mousedown', (e) => {
        isScrolling = true;
        startX = e.pageX - aparatList.offsetLeft;
        scrollLeft = aparatList.scrollLeft;
    });

    aparatList.addEventListener('mouseleave', () => {
        isScrolling = false;
        try {
            clearInterval(moveInterval);
        } catch (e) {
        }

    });
    aparatList.addEventListener('mouseenter', () => {
        moveInterval = setInterval( () => {
            if (!isScrolling) {
                const rect = aparatList.getBoundingClientRect();
                const isLeftSide = me.clientX - rect.left < rect.width / 5;
                const isRightSide = me.clientX > rect.right - rect.width / 5;
                console.log(isRightSide);

                if (isLeftSide && aparatList.scrollLeft > 0) {
                    aparatList.scrollLeft -= scrollSpeed;
                } else if (isRightSide && aparatList.scrollLeft < aparatList.scrollWidth - aparatList.clientWidth ) {
                    aparatList.scrollLeft += scrollSpeed;
                }
            }
        },1100);
    });

    aparatList.addEventListener('mouseup', () => {
        isScrolling = false;
    });

    aparatList.addEventListener('mousemove', (e) => {
        if (!isScrolling) return;
        e.preventDefault();
        const x = e.pageX - aparatList.offsetLeft;
        const walk = (x - startX) * 2;
        aparatList.scrollLeft = scrollLeft - walk;
    });


});
