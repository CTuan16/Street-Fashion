@extends('layout.layoutClient')

@section('title')
    Lịch sử mua hàng
@endsection

@section('body')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Lịch Sử Mua Hàng</h1>

        <!-- Order List -->
        <div class="space-y-6">
            @if($orders->count() > 0)
                @foreach($orders as $order)
                    <!-- Single Order -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-receipt text-gray-400"></i>
                                    <span class="text-sm text-gray-500">Mã đơn hàng:</span>
                                    <span class="font-medium text-gray-800">{{ $order->order_code }}</span>
                                     <span class="font-medium text-sm text-gray-500">{{  $order->payment->payment_status ?? 'Chưa thanh toán'  }}</span>
                                </div>
                                <div>
                                    @php
                                        $statusConfig = [
                                            9 => [
                                                'bg' => 'bg-yellow-100',
                                                'text' => 'text-yellow-800',
                                                'icon' => 'fas fa-spinner',
                                                'name' => 'Đang xử lý',
                                                'border' => 'border-yellow-200',
                                                'showCancel' => true
                                            ],
                                            12 => [
                                                'bg' => 'bg-green-100',
                                                'text' => 'text-green-800',
                                                'icon' => 'fas fa-check-circle',
                                                'name' => 'Đã xác nhận',
                                                'border' => 'border-green-200',
                                                'showCancel' => false
                                            ],
                                            13 => [
                                                'bg' => 'bg-red-100',
                                                'text' => 'text-red-800',
                                                'icon' => 'fas fa-times-circle',
                                                'name' => 'Đã hủy',
                                                'border' => 'border-red-200',
                                                'showCancel' => false
                                            ],
                                            11 => [
                                                'bg' => 'bg-blue-100',
                                                'text' => 'text-blue-800',
                                                'icon' => 'fas fa-truck',
                                                'name' => 'Đang giao hàng',
                                                'border' => 'border-blue-200',
                                                'showCancel' => false
                                            ],
                                            'default' => [
                                                'bg' => 'bg-gray-100',
                                                'text' => 'text-gray-800',
                                                'icon' => 'fas fa-info-circle',
                                                'name' => 'Khác',
                                                'border' => 'border-gray-200',
                                                'showCancel' => false
                                            ]
                                        ];

                                       $status = $order->orderStatus ? ($statusConfig[$order->orderStatus->id] ?? $statusConfig['default']) : $statusConfig['default'];

                                    @endphp

                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                                                {{ $status['bg'] }} {{ $status['text'] }} border {{ $status['border'] }}
                                                transition-all duration-300 hover:shadow-md">
                                            <i class="{{ $status['icon'] }} mr-2"></i>
                                            {{ $status['name'] }}
                                        </span>

                                        @if($status['showCancel'])
                                            <form action="{{ route('cancel.order', $order->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-red-500 text-white text-sm rounded-md hover:bg-red-600 focus:outline-none">
                                                    Hủy đơn
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4">
                            @foreach($order->orderDetails as $detail)
                                <div class="flex items-center space-x-4 mb-4">
                                    <img src="{{ asset($detail->product->primary_image) }}" alt="{{ $detail->product->name }}" class="h-20 w-20 object-cover rounded">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $detail->product->name }}</h3>
                                        <p class="text-sm text-gray-500">Số lượng: {{ $detail->quantity }}</p>
                                         <p class="text-sm text-gray-500">Màu: {{ $detail->color }}</p>
                                        <p class="text-sm text-gray-500">Size: {{ $detail->size }}</p>
                                       
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-medium text-gray-900">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}đ</p>
                                        <p class="text-sm text-gray-500">Ngày đặt: {{ $order->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-sm text-gray-500">Tổng tiền:</span>
                                    <span class="ml-2 text-lg font-medium text-gray-900">{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
                                </div>
                                <div class="flex space-x-3">
                                    <a href="{{ route('home') }}">
                                        <button class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Mua lại
                                        </button>
                                    </a>
                                    <a href="/detail/{{ $detail->product->id }}">
                                        <button class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Chi tiết
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-12">
                    <div class="mb-6">
                        <i class="fas fa-shopping-bag text-gray-300 text-6xl"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Chưa có đơn hàng nào</h3>
                    <p class="text-gray-500 mb-6">Bạn chưa có đơn hàng nào trong lịch sử mua sắm</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-500 hover:bg-gray-600">
                        Tiếp tục mua sắm
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection