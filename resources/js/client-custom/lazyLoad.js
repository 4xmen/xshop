// initialize event listener when dom is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    // check if lazy load is enabled
    const lazyLoad = document.getElementById('lazy-load')?.value;
    if (!lazyLoad) {
        console.log('lazy load is not enabled or input not found');
        return;
    }

    // hide pagination
    const pagination = document.querySelector('ul.pagination');
    if (pagination) {
        pagination.style.opacity = '.02';
    } else {
        console.log('pagination element not found');
    }

    // get the list row container
    const listRow = document.getElementById('list-row');
    if (!listRow) {
        console.log('list-row element not found');
        return;
    }

    // hide placeholder
    const placeholder = document.getElementById('place-holder');
    if (placeholder) {
        placeholder.style.display = 'none';
    } else {
        console.log('place-holder element not found');
    }

    // track current page
    let currentPage = 1;
    // track if loading is in progress
    let isLoading = false;

    // get base url from current pagination link
    const getBaseUrl = () => {
        const nextLink = document.querySelector('ul.pagination li.page-item a.page-link[rel="next"]');
        if (!nextLink) {
            console.log('next link not found, using current url');
            return window.location.href;
        }
        const href = nextLink.getAttribute('href');
        return href.split('?')[0]; // extract base url without query params
    };

    // function to get total pages dynamically
    const getTotalPages = () => {
        const lastPage = document.querySelector('#max-page').value;
        return lastPage;
    };

    // store current page info
    let totalPages = getTotalPages();

    // function to fetch and append next page using axios
    const loadNextPage = async () => {
        if (currentPage >= totalPages || isLoading) {
            console.log(`stopping load: currentPage=${currentPage}, totalPages=${totalPages}, isLoading=${isLoading}`);
            return;
        }

        isLoading = true;
        placeholder.style.display = 'flex';
        console.log(`loading page ${currentPage + 1}`);
        try {
            // increment page number
            currentPage++;
            const baseUrl = getBaseUrl();
            const response = await axios.get(`${baseUrl}?page=${currentPage}`);



            // append new rows to existing list
            listRow.innerHTML += response.data;
            console.log(`appended content for page ${currentPage}`);

            placeholder.style.display = 'none';

        } catch (error) {
            console.error('error loading next page:', error);
        } finally {
            isLoading = false;
        }
    };

    // set up intersection observer to trigger load when pagination is in view
    const paginationContainer = document.getElementById('active-pagination');
    if (!paginationContainer) {
        console.log('active-pagination element not found');
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !isLoading) {
                console.log('pagination container is visible, triggering load');
                loadNextPage();
            }
        });
    }, {
        root: null, // use viewport as root
        rootMargin: '100px', // trigger 100px before element is fully in view
        threshold: 0.1 // trigger when 10% of element is visible
    });

    // start observing the pagination container
    console.log('starting intersection observer');
    observer.observe(paginationContainer);
});
