
            
function sortProducts(sortBy) {
    const productGrid = document.querySelector('.grid');
    const products = Array.from(productGrid.children);

    products.sort((a, b) => {
        if (sortBy === 'name_asc') {
            return a.querySelector('h3').textContent.localeCompare(b.querySelector('h3').textContent);
        } else if (sortBy === 'name_desc') {
            return b.querySelector('h3').textContent.localeCompare(a.querySelector('h3').textContent);
        }
    });

    // Clear and re-append sorted products
    while (productGrid.firstChild) {
        productGrid.removeChild(productGrid.firstChild);
    }
    products.forEach(product => productGrid.appendChild(product));
}
