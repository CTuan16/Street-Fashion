@extends('layout.layoutClient')
@section('title')
Sản phẩm yêu thích
@endsection
@section('body')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Sản phẩm yêu thích của bạn</h1>
        <div class="flex items-center gap-2">
            <div class="bg-gray-100 px-4 py-2 rounded-full">
                <p class="text-gray-600 font-medium flex items-center gap-2">
                    <span>{{ count($favorite_products) }}</span>
                    <i class="fa-solid fa-heart text-red-500"></i>
                </p>
            </div>
        </div>
    </div>
    <div class="mb-8">
        <div class="bg-white rounded-lg  p-4">
            <div class="flex flex-col sm:flex-row items-center gap-6">
              
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <i class="fa-solid fa-arrow-down-a-z text-gray-500"></i>
                    <select id="sort-name" class="form-select w-full sm:w-auto rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 text-gray-600" onchange="sortProducts(this.value)">
                        <option value="" disabled selected>Sắp xếp theo tên</option>
                        <option value="name_asc">Tên A-Z</option>
                        <option value="name_desc">Tên Z-A</option>
                    </select>
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <i class="fa-solid fa-filter text-gray-500"></i>
                    <select id="price-filter" class="form-select w-full sm:w-auto rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 text-gray-600" onchange="sortByPrice(this.value)">
                        <option value="" disabled selected>Lọc và sắp xếp theo giá</option>
                        <option value="price_asc">Giá thấp đến cao</option>
                        <option value="price_desc">Giá cao đến thấp</option>
                        <option disabled>─────────────</option>
                        <option value="0-500000">Dưới 500,000đ</option>
                        <option value="500000-1000000">500,000đ - 1,000,000đ</option>
                        <option value="1000000-2000000">1,000,000đ - 2,000,000đ</option>
                        <option value="2000000-5000000">2,000,000đ - 5,000,000đ</option>
                        <option value="5000000-up">Trên 5,000,000đ</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="group relative bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300 p-4" data-price="{{ $meta->product_sale == 'sale' ? $meta->price_sale : $meta->price }}"> --}}


    @if(auth()->check())
        @if(count($favorite_products) > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 text-center ">
                @foreach($favorite_products as $favorite)
                    @if($favorite->product)
                        @php
                            $meta = $favorite->product->product_meta[0];
                        @endphp
                        <div class="flex flex-col text-center border border-gray-300 rounded-lg p-2 transition-all duration-500 hover:shadow-2xl hover:border-gray-400 transform hover:-translate-y-2 group" data-price="{{ $meta->product_sale == 'sale' ? $meta->price_sale : $meta->price }}">
                            <div class="relative overflow-hidden">
                                <div class="image-container">
                                    <img src="{{ asset($favorite->product->primary_image) }}" 
                                         alt="{{ $favorite->product->name }}"
                                         class="img-primary h-64 transition-all duration-700 group-hover:scale-110" />
                                    <img src="{{ asset($favorite->product->second_image) }}"
                                         alt="{{ $favorite->product->name }}"
                                         class="img-secondary h-64 transition-all duration-700 absolute inset-0 opacity-0 group-hover:opacity-100" />
                                    
                                    <!-- Overlay buttons -->
                                    <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center">
                                        <div class="flex gap-2 transform translate-y-full group-hover:translate-y-0 transition-all duration-500">
                                            <a href="/detail/{{ $favorite->product->id }}" class="bg-white p-2 rounded-full hover:bg-gray-200 transition-all duration-300 transform hover:scale-110">
                                                <i class="fas fa-eye text-gray-800"></i>
                                            </a>
                                            <button class="bg-white p-2 rounded-full hover:bg-gray-200 transition-all duration-300 transform hover:scale-110">
                                                <i class="fa-solid fa-cart-shopping text-gray-800"></i>
                                            </button>
                                            <form action="{{ route('add.favorite', $favorite->product->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-white p-2 rounded-full hover:bg-gray-200 transition-all duration-300 transform hover:scale-110">
                                                    @if(auth()->check() && auth()->user()->favorite_product->contains('id_product', $favorite->product->id))
                                                        <i class="fa-solid fa-heart text-red-500"></i>
                                                    @else
                                                        <i class="fa-solid fa-heart text-gray-800"></i>
                                                    @endif
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-center gap-3 mt-3">
                                <p class="text-sm text-gray-600">Màu sắc:</p>
                                <p class="text-sm text-gray-800">
                                    @foreach ($favorite->product->productcolor as $color)
                                        {{ $color->color['name_color'] }},
                                    @endforeach
                                </p>
                            </div>
                            <div class="flex justify-center gap-3">
                                <p class="text-sm text-gray-600">Kích thước:</p>
                                <p class="text-sm text-gray-800">
                                    @foreach ($favorite->product->productsize as $size)
                                    {{ $size->size['name_size'] }},
                                @endforeach
                                </p>
                            </div>
                            <h3 class="mt-2 font-semibold text-gray-800 truncate hover:text-gray-600 transition-all duration-300">
                                <p>{{ $favorite->product->name }}</p>
                            </h3>
                            <div class="flex flex-col items-center gap-1">
                                @foreach($favorite->product->product_meta as $meta)
                                    @if($meta->product_sale == 'sale')
                                        <p class="text-gray-500 line-through text-sm">{{ number_format($meta->price) }} VND</p>
                                        <div class="flex items-center gap-2">
                                            <span class="text-red-600 font-bold text-lg">{{ number_format($meta->price_sale) }} VND</span>
                                            <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow-md animate-pulse">SALE</span>
                                        </div>
                                    @else
                                        <span class="text-gray-900 font-medium">{{ number_format($meta->price) }} VND</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-xl shadow-sm">
                <i class="fa-regular fa-heart text-6xl"></i>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Chưa có sản phẩm yêu thích</h3>
                <p class="mt-2 text-sm text-gray-500">Hãy thêm những sản phẩm bạn yêu thích vào danh sách</p>
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center px-6 py-3 mt-6 border border-transparent text-sm font-medium rounded-lg text-white bg-gray-900 hover:bg-gray-800 transition duration-200">
                    Khám phá ngay
                </a>
            </div>
        @endif
    @endif
    
</div>
<script src="/js/favorite_product/format_price.js"></script>
<script src="/js/favorite_product/format_name_price.js"></script>
@endsection

