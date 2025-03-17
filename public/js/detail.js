document.getElementById('toggle-btn').addEventListener('click', function() {
    const productDetails = document.getElementById('product-details');
  
    // Kiểm tra xem productDetails có đang hiển thị hay không
    if (productDetails.style.display === 'none' || productDetails.style.display === '') {
      productDetails.style.display = 'block'; // Hiển thị phần tử
    } else {
      productDetails.style.display = 'none'; // Ẩn phần tử
    }
  });

  // size guide modal    // Size guide modal functionality
    const sizeGuideBtn = document.getElementById('sizeGuideBtn');
    const sizeGuideModal = document.getElementById('sizeGuideModal');
    const closeModal = document.getElementById('closeModal');

    sizeGuideBtn.addEventListener('click', () => {
        sizeGuideModal.classList.add('open');
    });

    closeModal.addEventListener('click', () => {
        sizeGuideModal.classList.remove('open');
    });

    // Close modal when clicking outside
    sizeGuideModal.addEventListener('click', (e) => {
        if (e.target === sizeGuideModal) {
            sizeGuideModal.classList.remove('open');
        }
    });