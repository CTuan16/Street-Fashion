<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán Bằng Mã QR</title>
    <style>
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }

        img {
            width: 300px;
            height: 300px;
            margin-bottom: 20px;
        }

        h1 {
            margin-bottom: 10px;
            color: #333;
        }

        p {
            font-size: 16px;
        }
        /* Container chính */
.countdown-timer {
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Roboto', sans-serif;
    font-size: 2.5rem;
    font-weight: bold;
    color: #ffffff;
    border-radius: 10px;
    padding: 10px 20px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
    width: fit-content;
    margin: 20px auto;
}
.button-group {
        display: flex;
        flex-direction: row;
        margin-top: 50px;
        justify-content: center;
    }

    a {
        text-decoration: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    a:first-child {
        background-color: #4f46e5; /* Indigo */
        color: white;
        border: none;
    }

    a:first-child:hover {
        background-color: #4338ca; /* Darker Indigo */
    }

    a:last-child {
        background-color: white;
        color: #4a5568; /* Gray */
        border: 2px solid #e2e8f0;
    }

    a:last-child:hover {
        background-color: #edf2f7; /* Light Gray */
    }    

/* Các phần hiển thị thời gian */
.time-part {
    display: inline-block;
    min-width: 50px; /* Đảm bảo đồng đều kích thước */
    text-align: center;
    color: #ffffff;
    background: #333333;
    border-radius: 8px;
    padding: 5px 10px;
    margin: 0 5px;
}

/* Dấu phân cách */
.separator {
    color: #ffffff;
    font-size: 2rem;
    margin: 0 5px;
}

/* Hiệu ứng hover */
.countdown-timer:hover {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}

/* Hiệu ứng cảnh báo gần hết thời gian */
.time-part.warning {
    color: #ff0000;
    background: #ffcccc;
    animation: blink 1s infinite; /* Nhấp nháy khi gần hết thời gian */
}

/* Hiệu ứng nhấp nháy */
@keyframes blink {
    50% {
        opacity: 0.5;
    }
}

    </style>
</head>
<body>
    <div class="container">
    <div id="countdown-timer">
    </div>
        <h1>Quét Mã QR Để Thanh Toán</h1>
        <img src="{{ $qrUrl }}" alt="QR Code">
        <p>Mã đơn hàng: <strong>{{ $order->order_code }}<strong></p>
        <p style="margin-bottom: 20px;">Số tiền cần thanh toán: <strong>{{ $order->total_amount }}</strong></p>
        <div class="button-group">
            <a href="/">Thanh toán sau</a>
        </div>
        </div>
    </div>
    
</body>
</html>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>





<script>
    let countdownTime = 10 * 60; // 10 phút tính bằng giây
    let paymentChecked = false; // Trạng thái kiểm tra thanh toán

    // Hàm cập nhật đồng hồ đếm ngược
    function updateCountdown() {
        if (paymentChecked) {
            clearInterval(timerInterval); // Dừng đếm ngược nếu đã nhận kết quả thành công
            return;
        }

        const minutes = Math.floor(countdownTime / 60); // Số phút
        const seconds = countdownTime % 60; // Số giây còn lại

        // Hiển thị thời gian ở định dạng MM:SS
        document.getElementById('countdown-timer').textContent =
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

        // Nếu hết thời gian, dừng đếm ngược
        if (countdownTime <= 0) {
            clearInterval(timerInterval);
            alert('Hết thời gian! Vui lòng kiểm tra thanh toán thủ công.');
            return;
        }

        countdownTime--; // Giảm thời gian còn lại
    }

function sendCheckPayment() {
    if (paymentChecked || countdownTime <= 0) {
        return;
    }

    $.ajax({
        url: '/checkPayment',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            order_id: '{{$order->order_code}}'
        },
        success: function(response) {
            if (response.success && response.redirect_url) {
                paymentChecked = true;
                clearInterval(timerInterval);
                clearInterval(ajaxInterval);
                window.location.href = response.redirect_url + '?orderCode={{$order->order_code}}'; // Điều hướng tới trang thành công
            }
        },
        error: function(error) {
            console.error('Lỗi khi kiểm tra thanh toán:', error);
        }
    });
}


    // Bắt đầu đếm ngược và gửi AJAX mỗi 5 giây
    const timerInterval = setInterval(updateCountdown, 1000); // Cập nhật mỗi giây
    const ajaxInterval = setInterval(sendCheckPayment, 5000); // Gửi AJAX mỗi 5 giây

    // Dừng gửi AJAX khi hết thời gian
    setTimeout(() => {
        clearInterval(ajaxInterval); // Dừng AJAX sau 10 phút
    }, countdownTime * 1000);

    updateCountdown(); // Chạy ngay lập tức lần đầu tiên
</script>

