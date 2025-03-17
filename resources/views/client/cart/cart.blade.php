@extends('layout.layoutClient')

@section('title')
    Giỏ Hàng
@endsection

@section('body')
<div class="container mx-auto p-8 max-w-7xl rounded-lg shadow-lg mt-8 mb-8" style="border: solid #EAD99E 1px;">
    <h1 class="text-4xl font-bold text-center text-gray-900 mb-10">Giỏ Hàng Của Bạn</h1>

    @if(session('cart.' . auth()->id()) && count(session('cart.' . auth()->id())) > 0)
        <!-- Bảng giỏ hàng -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray mx-auto">
                <thead>
                    <tr class="border-b text-xs font-semibold text-gray-600 uppercase tracking-wide text-0xl">
                        <th class="py-3 px-4 text-center">Sản phẩm</th>
                        <th class="py-3 px-4 text-center">Màu sắc</th>
                        <th class="py-3 px-4 text-center">Số lượng</th>
                        <th class="py-3 px-4 text-center">Giá</th>
                        <th class="py-3 px-4 text-center">Tổng cộng</th>
                        <th class="py-3 px-4 text-center">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <form action="{{ route('cart.update') }}" method="POST" id="cartForm">
                        @csrf
                    @foreach(session('cart.' . auth()->id()) as $id => $item)
                        @php
                            $itemTotal = $item['price'] * $item['quantity'];
                        @endphp
                        <tr class="hover:bg-gray-100 transition-colors">
                            <td class="py-5 px-4 flex items-center space-x-4">
                                <img src="{{asset($item['image'])}}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded-md shadow-md">
                                <div>
                                    <p class="font-semibold text-gray-900 text-base">{{ $item['name'] }}</p>
                                    <p class="text-sm text-gray-500">Size: {{ $item['size'] }}</p>
                                </div>
                            </td>
                            <td class="py-5 px-4 text-center">
                                <span class="inline-block px-3 py-1 text-gray-700 bg-gray-200 rounded-full text-sm">{{ $item['color'] }}</span>
                            </td>
                            <td class="py-5 px-4 text-center">
                                <input type="number" 
                                    class="quantity w-14 text-center border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" 
                                    value="{{ $item['quantity'] }}" 
                                    name="quantities[{{ $id }}]"
                                    min="1"
                                    data-id="{{ $id }}"
                                    data-price="{{ $item['price'] }}"
                                    onchange="updateTotal(this)">
                            </td>
                            <td class="py-5 px-4 text-center">
                                <span class="inline-block px-3 py-1 text-gray-700 text-sm">{{ number_format($item['price'], 0, ',', '.') }} VND</span>
                            </td>
                            <td class="py-5 px-4 text-center">
                                <span class="item-total inline-block px-3 py-1 text-gray-700 text-sm">{{ number_format($itemTotal, 0, ',', '.') }} VND</span>
                            </td>
                            <td class="py-5 px-4 text-center">
                                <a href="{{ route('cart.remove', $id) }}">
                                        <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
            
                </tbody>
            </table>
        </div>

        <!-- Tổng kết đơn hàng -->
        <div class="mt-10 flex justify-between items-center border-t pt-6">
            <div class="text-lg">
                <p class="text-gray-700">Tổng tiền đơn hàng: <span id="cart-total" class="font-semibold">{{ number_format($total, 0, ',', '.') }} VND</span></p>
            </div>
        
                <button id="checkout" type="submit" class="bg-gray-600 text-white font-semibold rounded-md px-6 py-3 hover:bg-gray-700 transition">Thanh toán</button>

        </div>

    @else
        <p class="text-center text-gray-700">Giỏ hàng của bạn đang trống.</p>
    @endif
            </form>
</div>
<script src="https://kit.fontawesome.com/e7db34f14d.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/cart.js') }}"></script>
@endsection


