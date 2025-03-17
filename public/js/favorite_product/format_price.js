function sortByPrice(sortBy) {
    const productGrid = document.querySelector('.grid');
    const products = Array.from(productGrid.children);

    products.sort((a, b) => {
        const priceA = parseFloat(a.dataset.price);
        const priceB = parseFloat(b.dataset.price);

        if (sortBy === 'price_asc') {
            return priceA - priceB;
        } else if (sortBy === 'price_desc') {
            return priceB - priceA;
        }
    });

    // Clear and re-append sorted products
    while (productGrid.firstChild) {
        productGrid.removeChild(productGrid.firstChild);
    }
        products.forEach(product => productGrid.appendChild(product));
}