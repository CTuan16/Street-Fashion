@extends('admin.layoutv2.layout.app')

@section('content')
<div id="wrapper" class="h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6 overflow-hidden">
    <div class="mx-auto h-full flex flex-col">
        <div id="home" class="flex-1 overflow-auto">
            <!-- Breadcrumb -->
            <nav class="text-sm font-medium mb-4" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2 text-gray-600">
                    <li>
                        <a href="#" class="hover:text-blue-600 transition duration-200">Đơn hàng</a>
                        <span class="text-gray-400 mx-2">/</span>
                    </li>
                    <li class="text-gray-800">Chi tiết</li>
                </ol>
            </nav>

            <h1 class="text-3xl font-bold text-gray-800 mb-6">Chi tiết đơn hàng</h1>
            
            <div class="grid grid-cols-1 gap-6 mb-6 max-w-6xl mx-auto">
                <!-- User Information Section -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <!-- User Information -->
                        <div>
                            <div class="flex items-center space-x-3 mb-4">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <h2 class="text-xl font-bold text-gray-800">Thông tin người mua</h2>
                            </div>

                            <div class="space-y-4 text-gray-600">
                                @if ($order->user)
                                    <div class="text-lg font-semibold text-gray-800">{{ $order->user->name }}</div>
                                    <div>
                                    
                                        <p class="text-base text-gray-600">
                                            @php
                                                // Tách địa chỉ thành các phần
                                                $parts = explode(',', $order->address);
                                                
                                                // Lấy số điện thoại và địa chỉ cụ thể
                                                $phone = trim($parts[0]);
                                                $specificAddress = trim($parts[1]);
                                                
                                                // Lấy ID của phường/quận/thành phố
                                                $wardId = trim($parts[count($parts)-3]);
                                                $districtId = trim($parts[count($parts)-2]);
                                                $provinceId = trim($parts[count($parts)-1]);
                                                
                                                // Cache API data
                                                $apiData = Cache::remember('location_data', 60*24, function() {
                                                    return Http::get('https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json')->json();
                                                });
            
                                                // Chuyển đổi ID thành tên
                                                $province = collect($apiData)->firstWhere('Id', $provinceId);
                                                $district = $province ? collect($province['Districts'])->firstWhere('Id', $districtId) : null;
                                                $ward = $district ? collect($district['Wards'])->firstWhere('Id', $wardId) : null;
                                                
                                                // Tạo địa chỉ đầy đủ
                                                $fullAddress = sprintf(
                                                    'SĐT: %s, %s, %s, %s, %s',
                                                    $phone,
                                                    $specificAddress,
                                                    $ward ? $ward['Name'] : $wardId,
                                                    $district ? $district['Name'] : $districtId,
                                                    $province ? $province['Name'] : $provinceId
                                                );
                                            @endphp
                                            {{ $fullAddress }}
                                        </p>
                                    </div>
                                @else
                                    <p class="text-base text-red-500">Người mua không tồn tại.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Order Status Information -->
                        <div class="space-y-6">
                            <!-- Trạng thái đơn hàng -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="text-lg font-bold text-gray-800">Trạng thái đơn hàng</h3>
                                </div>
                                <p class="text-lg text-green-600 font-semibold">{{ $order->orderStatus->status_name ?? 'Chưa xác định' }}</p>
                            </div>

                            <!-- Trạng thái thanh toán -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="text-lg font-bold text-gray-800">Trạng thái thanh toán</h3>
                                </div>
                                <p class="text-lg text-yellow-600 font-semibold">{{ $order->payment->payment_status ?? 'Chưa thanh toán' }}</p>
                            </div>

                            <!-- Mã giảm giá -->
                            @if($order->voucher)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                    <h3 class="text-lg font-bold text-gray-800">Mã giảm giá</h3>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg text-red-600 font-semibold">{{ $order->voucher->code }}</p>
                                    <p class="text-sm text-gray-600">Giảm {{ number_format($order->voucher->discount, 0, ',', '.') }} đ</p>
                                </div>
                            </div>
                            @endif


                            <div class="flex items-center justify-between pt-4 border-t">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="text-lg font-bold text-gray-800">Tổng tiền</h3>
                                </div>
                                <p class="text-xl text-purple-600 font-bold">{{ number_format($order->total_amount, 0, ',', '.') }} đ</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Details Table -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 flex items-center space-x-2">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-800">Chi tiết sản phẩm</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Sản phẩm</th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Số lượng</th>
                                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Giá</th>
                                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Voucher</th>
                                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Tổng tiền</th>
                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($order->orderDetails as $detail)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-4">
                                                <img src="{{ asset($detail->product->primary_image) }}" alt="{{ $detail->product->name }} {{ $detail->size }} {{ $detail->color }}"
                                                    class="w-16 h-16 object-cover rounded-lg shadow-sm">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-gray-800">{{ $detail->product->name }}</span>
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $detail->size }}</span>
                                                        <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">{{ $detail->color }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center font-medium text-gray-700">{{ $detail->quantity }}</td>
                                        <td class="px-6 py-4 text-right font-medium text-gray-700">{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                                        <td class="px-6 py-4 text-right font-medium text-red-600">
                                            @if($order->voucher && $loop->first)
                                                <div class="flex justify-end items-center gap-2">
                                                    <span>{{ $order->voucher->code }}</span>
                                                    <span class="text-gray-500">-{{ number_format($order->voucher->discount, 0, ',', '.') }} đ</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right font-bold text-indigo-600">{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection
