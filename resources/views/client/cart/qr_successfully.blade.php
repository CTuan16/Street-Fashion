@extends('layout.layoutClient')

@section('title')
    Đặt hàng thành công
@endsection

@section('body')
<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 ">
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 sm:px-10">
            <div class="flex flex-col items-center">
                <!-- Success Animation -->
                <div class="rounded-full bg-green-100 p-6 mb-6">
                    <svg class="w-16 h-16 text-green-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Thanh toán thành công!</h2>
                <p class="text-gray-600 text-center mb-8">Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi</p>

                <!-- Order Info -->
                <div class="w-full bg-gray-50 rounded-lg p-6 mb-8">
                    <div class="flex justify-between mb-4">
                        <span class="text-gray-600">Mã đơn hàng:</span>
                        <span class="font-medium text-gray-900" id="orderCode"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Trạng thái:</span>
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                            Đang xử lý
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 w-full">
                    <a href="{{ route('purchase.history') }}" 
                       class="flex-1 flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Xem đơn hàng
                    </a>
                    <a href="/" 
                       class="flex-1 flex justify-center items-center px-6 py-3 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-6 text-center text-sm text-gray-600">
            <p>Bạn sẽ nhận được email xác nhận đơn hàng trong vòng vài phút</p>
            <p class="mt-2">Nếu cần hỗ trợ, vui lòng liên hệ 
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Hotline: 1900 xxxx
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', () => {
    const orderCode = new URLSearchParams(window.location.search).get('orderCode');
    const orderCodeElement = document.getElementById('orderCode');

    // Kiểm tra và cập nhật nếu orderCode tồn tại và phần tử cũng tồn tại
    if (orderCode && orderCodeElement) {
        orderCodeElement.textContent = orderCode;
    } else {
        console.log(orderCode ? "Phần tử orderCode không tồn tại" : "Không tìm thấy tham số orderCode trong URL");
    }
});




</script>
