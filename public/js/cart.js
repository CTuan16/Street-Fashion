function updateTotal(input) {
    const quantity = parseInt(input.value);
    const price = parseFloat(input.dataset.price);
    const itemTotal = quantity * price;
    
    // Cập nhật tổng tiền của sản phẩm
    const formattedItemTotal = new Intl.NumberFormat('vi-VN').format(itemTotal) + ' VND';
    input.closest('tr').querySelector('.item-total').textContent = formattedItemTotal;
    
    // Tính tổng giỏ hàng mới
    let cartTotal = 0;
    document.querySelectorAll('.quantity').forEach(qtyInput => {
        cartTotal += parseFloat(qtyInput.value) * parseFloat(qtyInput.dataset.price);
    });
    
    // Cập nhật tổng giỏ hàng
    const formattedCartTotal = new Intl.NumberFormat('vi-VN').format(cartTotal) + ' VND';
    document.getElementById('cart-total').textContent = formattedCartTotal;
}