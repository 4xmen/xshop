document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.nested-list')?.forEach(function (list) {
        list.querySelectorAll('li').forEach(function (li) {
            // Check if the <li> has a <ul> child
            const ulChild = Array.from(li.children).find(child => child.tagName === 'UL');

            // Check if the <ul> is not empty (has at least one <li> child)
            const hasLiChildInUl = ulChild && ulChild.querySelectorAll('li').length > 0;

            if (hasLiChildInUl) {
                let plus = document.createElement('i');
                plus.setAttribute('class','ri-arrow-down-wide-line float-end mx-2');
                li.prepend(plus);
                li.classList.add('nested-parent');
                plus.addEventListener('click',function () {
                    this.parentNode.querySelector(':scope > ul').classList.toggle('active');
                    if (this.classList.contains('ri-arrow-down-wide-line')){
                        span.classList.remove('ri-arrow-down-wide-line');
                        span.classList.add('ri-arrow-up-wide-line');
                    }else{
                        span.classList.remove('ri-arrow-up-wide-line');
                        span.classList.add('ri-arrow-down-wide-line');

                    }
                });
            }
        });
    });
});
