document.getElementById('commentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const content = document.getElementById('content').value;
    const errorDiv = document.getElementById('error-message');
    const productId = window.location.pathname.split('/').pop(); // Get product ID from URL
    
    // Create form data
    const formData = new FormData();
    formData.append('content', content);
    formData.append('_token', document.querySelector('input[name="_token"]').value);

    fetch(`/detail/${productId}`, {
        method: 'POST', 
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        window.location.reload(); // Reload page to show new comment
    })
    .catch(error => {
        console.error('Error:', error);
        errorDiv.querySelector('p').textContent = 'Có lỗi xảy ra, vui lòng thử lại sau';
        errorDiv.classList.remove('hidden');
    });
});

//rating

function highlightStars(num) {
    const stars = document.querySelectorAll('label[for^="star"]');
    stars.forEach((star, index) => {
        if (index < num) {
            star.classList.add('text-yellow-400');
            star.classList.remove('text-gray-300');
        }
    });
}

function resetStars() {
    const stars = document.querySelectorAll('label[for^="star"]');
    const selectedRating = document.querySelector('input[name="rating"]:checked');
    stars.forEach((star, index) => {
        if (!selectedRating || index >= selectedRating.value) {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300');
        }
    });
}

function selectStar(num) {
    const stars = document.querySelectorAll('label[for^="star"]');
    stars.forEach((star, index) => {
        if (index < num) {
            star.classList.add('text-yellow-400');
            star.classList.remove('text-gray-300');
        } else {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300');
        }
    });
}

