@extends('admin.layoutv2.layout.app')

@section('content')
<div id="wrapper" class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="container mx-auto px-6 py-8">
        <div id="home">
            <!-- Breadcrumb -->
            <nav class="text-sm font-medium mb-8" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2 text-gray-600">
                    <li>
                        <a href="#" class="hover:text-blue-600 transition duration-200">Home</a>
                        <span class="text-gray-400 mx-2">/</span>
                    </li>
                    <li class="text-gray-800">Dashboard</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Tổng đơn hàng -->
                <div class="bg-gradient-to-br from-green-100 to-green-200 rounded-xl shadow-lg p-4 transform hover:scale-105 transition duration-300">
                    <div class="flex flex-col items-center justify-center space-y-2">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-gray-800">{{ number_format($totalOrdersByDate ?? 0, 0, ',', '.') }}</p>
                            <p class="text-gray-600 font-medium mt-1">Tổng đơn hàng 
                                @if($selectedType == 'day')
                                    ngày
                                @elseif($selectedType == 'month')
                                    tháng
                                @else
                                    năm
                                @endif
                            </p>
                        </div>
                        
                        <form action="{{ route('admin.homev2') }}" method="GET" class="flex space-x-2">
                            <input 
                                type="date" 
                                name="date" 
                                value="{{ $selectedDate }}"
                                class="rounded-lg border-gray-300 text-sm"
                            >
                            <select name="type" class="rounded-lg border-gray-300 text-sm">
                                <option value="day" {{ $selectedType == 'day' ? 'selected' : '' }}>Theo ngày</option>
                                <option value="month" {{ $selectedType == 'month' ? 'selected' : '' }}>Theo tháng</option>
                                <option value="year" {{ $selectedType == 'year' ? 'selected' : '' }}>Theo năm</option>
                            </select>
                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-600">
                                Xem
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Thu nhập tháng -->
                <div class="bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-xl shadow-lg p-4 transform hover:scale-105 transition duration-300">
                    <div class="flex flex-col items-center justify-center space-y-2">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-gray-800">{{ number_format($income ?? 0, 0, ',', '.') }} đ</p>
                            <p class="text-gray-600 font-medium mt-1">Thu nhập 
                                @if($selectedType == 'day')
                                    ngày
                                @elseif($selectedType == 'month')
                                    tháng
                                @else
                                    năm
                                @endif
                            </p>
                        </div>
                        
                        
                    </div>
                </div>

                <!-- Tổng danh mục -->
                <div class="bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl shadow-lg p-4 transform hover:scale-105 transition duration-300">
                    <div class="flex items-center justify-center space-x-4">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-gray-800">{{ $totalCategory ?? 0 }}</p>
                            <p class="text-gray-600 font-medium mt-1">Tổng danh mục</p>
                        </div>
                    </div>
                </div>

                <!-- Sản phẩm đang sale -->
                <div class="bg-gradient-to-br from-red-100 to-red-200 rounded-xl shadow-lg p-4 transform hover:scale-105 transition duration-300">
                    <div class="flex items-center justify-center space-x-4">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-gray-800">{{ number_format($totalProductsOnSale ?? 0, 0, ',', '.') }}</p>
                            <p class="text-gray-600 font-medium mt-1">Sản phẩm đang sale</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Danh mục nổi bật -->
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Sản phẩm nổi bật</h3>
                    <ul class="space-y-3">
                        @foreach ($category as $cat)
                            <li class="flex items-center justify-between bg-gradient-to-r from-{{ ['pink', 'blue', 'green', 'purple', 'yellow', 'indigo'][rand(0,5)] }}-100 to-{{ ['pink', 'blue', 'green', 'purple', 'yellow', 'indigo'][rand(0,5)] }}-100 p-4 rounded-xl shadow-sm hover:bg-gray-50 transition duration-200">
                                <span class="text-xl font-bold text-gray-800">{{ $cat->name }}</span>
                                <span class="text-lg bg-white bg-opacity-60 text-gray-700 font-bold py-2 px-4 rounded-full">{{ $cat->product_count }} sản phẩm</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Recent Transactions -->
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Thống kê đơn hàng</h3>
                    </div>
                    <div class="space-y-4">
                        <!-- Đơn hàng đã giao -->
                        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-4 flex justify-between items-center">
                            <div>
                                <p class="font-bold text-lg text-gray-800">Đơn hàng đã giao</p>
                                <p class="text-sm text-gray-600">Đã giao thành công</p>
                            </div>
                            <span class="text-2xl font-bold text-green-600 delivered-orders">{{ $totalOrders['delivered'] ?? 0 }}</span>
                        </div>

                        <!-- Đơn hàng đang giao -->
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-4 flex justify-between items-center">
                            <div>
                                <p class="font-bold text-lg text-gray-800">Đơn hàng đang giao</p>
                                <p class="text-sm text-gray-600">Đang giao</p>
                            </div>
                            <span class="text-2xl font-bold text-blue-600 shipping-orders">{{ $totalOrders['shipping'] ?? 0 }}</span>
                        </div>

                        <!-- Đơn hàng chờ xử lý -->
                        <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-xl p-4 flex justify-between items-center">
                            <div>
                                <p class="font-bold text-lg text-gray-800">Đơn hàng chờ xử lý</p>
                                <p class="text-sm text-gray-600">Chờ xử lý</p>
                            </div>
                            <span class="text-2xl font-bold text-orange-600 pending-orders">{{ $totalOrders['pending'] ?? 0 }}</span>
                        </div>

                        <!-- Đơn hàng đã hủy -->
                        <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-xl p-4 flex justify-between items-center">
                            <div>
                                <p class="font-bold text-lg text-gray-800">Đơn hàng đã hủy</p>
                                <p class="text-sm text-gray-600">Đã hủy</p>
                            </div>
                            <span class="text-2xl font-bold text-red-600 canceled-orders">{{ $totalOrders['canceled'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lấy các element input date và select type
    const dateInput = document.querySelector('input[name="date"]');
    const typeSelect = document.querySelector('select[name="type"]');
    
    // Hàm cập nhật số liệu thống kê
    function updateStats() {
        const date = dateInput.value;
        const type = typeSelect.value;
        
        // Gọi AJAX để lấy dữ liệu mới
        fetch(`{{ route('admin.homev2') }}?date=${date}&type=${type}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Cập nhật tổng đơn hàng
            document.querySelector('.total-orders').textContent = data.totalOrdersByDate;
            
            // Cập nhật thu nhập
            document.querySelector('.income').textContent = data.income;
            
            // Cập nhật các số liệu thống kê đơn hàng
            document.querySelector('.delivered-orders').textContent = data.totalOrders.delivered;
            document.querySelector('.shipping-orders').textContent = data.totalOrders.shipping;
            document.querySelector('.pending-orders').textContent = data.totalOrders.pending;
            document.querySelector('.canceled-orders').textContent = data.totalOrders.canceled;
        });
    }

    // Đăng ký sự kiện khi người dùng thay đổi date hoặc type
    dateInput.addEventListener('change', updateStats);
    typeSelect.addEventListener('change', updateStats);
});
</script>