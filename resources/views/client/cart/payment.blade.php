@extends('layout.layoutClient')

@section('title')
    Thanh toán
@endsection

@section('body')
<div class="container mx-auto p-6  rounded-lg shadow-lg max-w-7xl mt-8 mb-8" style="border: solid #EAD99E 1px;">

    <h1 class="text-4xl font-bold text-center text-gray-900 mb-10">Thanh Toán</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Thông tin người dùng -->
        <div class="bg-white p-6 rounded-lg " style="border: solid #EAD99E 1px;">
            <h2 class="text-2xl font-bold mb-6 text-gray-700">Thông tin của bạn</h2>
            <form action="{{ route('order.store') }}" method="POST" >
            @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Tên:</label>
                    <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-semibold mb-2">Số điện thoại:</label>
                    <input type="tel" id="phone" name="phone" value="{{ Auth::user()->phone }}" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email:</label>
                    <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 font-semibold mb-2">Địa chỉ:</label>
                    <textarea id="address" name="address" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500" required>{{ Auth::user()->address }}</textarea>
                </div>

                <!-- Thêm chọn tỉnh, huyện, xã -->
                <div class="mb-4">
                    <label for="province" class="block text-gray-700 font-semibold mb-2">Tỉnh/Thành phố:</label>
                    <select name="province" id="province" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="" >Chọn tỉnh/thành phố</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="district" class="block text-gray-700 font-semibold mb-2">Quận/Huyện:</label>
                    <select id="district" name="district" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Chọn quận/huyện</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="ward" class="block text-gray-700 font-semibold mb-2">Phường/Xã:</label>
                    <select id="ward" name="ward" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Chọn phường/xã</option>
                    </select>
                </div>
            
        </div>

        <!-- Thông tin đơn hàng -->
        <div class="bg-white p-6 rounded-lg " style="border: solid #EAD99E 1px;">
            <h2 class="text-2xl font-bold mb-6 text-gray-700">Thông tin đơn hàng</h2>
            <div class="border border-gray-300 rounded-lg p-6 mb-6">
                <!-- Danh sách sản phẩm -->
                <div class="space-y-4">
                    @php
                        $userId = auth()->id();
                        $cart = session()->get('cart.' . $userId, []);
                        $total = 0;
                    @endphp

                    @foreach($cart as $id => $item)
                        @php
                            $itemTotal = $item['price'] * $item['quantity'];
                            $total += $itemTotal;
                        @endphp
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 rounded-md mr-4">
                                <div>
                                    <p class="text-gray-800 font-semibold">{{ $item['name'] }}</p>
                                    <p class="text-gray-800">Size: {{ $item['size'] }}</p>
                                    <p class="text-gray-800">Màu: {{ $item['color'] }}</p>
                                    <p class="text-gray-800">Số lượng: {{ $item['quantity'] }}</p>
                                </div>
                            </div>
                            <p class="text-gray-600">{{ number_format($itemTotal, 0, ',', '.') }} VND</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 border-t pt-4">
                    <!-- Input for Khuyến mãi -->
                    <div class="mb-4">
                        <label for="voucher_id" class="block text-gray-700 font-semibold mb-2">Mã khuyến mãi:</label>
                        <div class="flex">
                            <input type="text" id="voucher_id" name="voucher_id" placeholder="Nhập mã khuyến mãi" class="w-full border border-gray-300 rounded-md px-4 py-2">
                            <button type="button" id="apply_voucher" class="ml-4 bg-blue-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-blue-700">
                                Áp dụng
                            </button>
                        </div>
                        <div id="voucher-message" class="text-red-600 mt-2 hidden"></div>
                    </div>

                    <div class="flex items-center justify-between">
                        <p class="text-gray-700">Phí vận chuyển:</p>
                        <p class="text-gray-600">{{ number_format(setting('fee_ship')) }} VND</p>
                    </div>
                    
                    <!-- Khuyến mãi -->
                    <div class="flex items-center justify-between">
                        <p class="text-gray-700">Khuyến mãi:</p>
                        <p id="voucher_discount" class="text-gray-600">0 VND</p>
                    </div>
                @php
                    $totalAmount = $total + setting('fee_ship');
                @endphp
                    <div class="flex items-center justify-between font-bold text-xl mt-2">
                        <p class="text-gray-900">Tổng cộng:</p>
                        <p id="total_amount" name="total_amount" class="text-gray-900">{{ number_format($totalAmount, 0, ',', '.') }} VND</p>
                    </div>
                </div>
                
            </div>

            <!-- Phương thức thanh toán -->
            <h2 class="text-2xl font-bold mb-6 text-gray-700">Phương thức thanh toán</h2>
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="radio" name="payment_method" value="COD" class="mr-3" required>
                    <span class="text-gray-700">Thanh toán khi nhận hàng</span>
                </label>
             
                <label class="flex items-center">
                    <input type="radio" name="payment_method" value="BANK" class="mr-3">
                    <span class="text-gray-700">Thanh toán qua mã QR</span>
                    <img src="/img/mbbank.png" alt="MB" class="w-8 h-8 ml-2">
                </label>
               
            </div>
            {{-- <p>{{$total}} </p> --}}
            <input type="hidden" id="total_amount" name="total_amount" value="{{$totalAmount}}">    

            <button type="submit" class="w-full bg-blue-600 text-white font-semibold rounded-md px-4 py-3 mt-6 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" >
                
                Đặt hàng
            </button>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/api_city.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    $('#apply_voucher').on('click', function() {
    var voucherCode = $('#voucher_id').val(); // Lấy mã voucher từ input
    var totalAmount = parseInt($('#total_amount').text().replace(/[^0-9]/g, '')); // Lấy tổng tiền hiện tại

    $.ajax({
        url: `{{ route('apply.voucher') }}`,// URL của route applyVoucher
        method: 'POST',
        data: {
            voucher_code: voucherCode, // Mã voucher người dùng nhập
            total_amount: totalAmount, // Tổng tiền của đơn hàng
            _token: '{{ csrf_token() }}' // Thêm CSRF token bảo mật
        },
        success: function(response) {
            if (response.success) {
                // Voucher hợp lệ, cập nhật giá trị giảm giá và tổng tiền mới
                var discount = response.discount; // Lấy giá trị giảm giá
                var newTotalAmount = totalAmount - discount; // Tính tổng tiền mới sau khi áp dụng voucher

                // Cập nhật giao diện
                $('#voucher_discount').text(discount.toLocaleString() + ' VND');
                $('#total_amount').text(newTotalAmount.toLocaleString() + ' VND');
                $('#voucher-message').addClass('hidden'); // Ẩn thông báo lỗi nếu có
            } else {
                // Nếu voucher không hợp lệ, hiển thị thông báo lỗi
                $('#voucher-message').text(response.message).removeClass('hidden');
            }
        }
    });
});
</script>   

@endsection
