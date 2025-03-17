@extends('layout.layoutClient')
@section('title')
    Sản phẩm bán chạy
@endsection
@section('body')
    <div class="container mx-auto p-8 max-w-7xl">
        <h1 class="text-4xl font-bold text-center text-gray-900 mb-10 relative group">
            <span class="relative inline-block">
                Tất cả sản phẩm bán chạy
                <span class="absolute bottom-0 left-0 w-full h-1 bg-red-500 transform scale-x-0 transition-transform duration-300 group-hover:scale-x-100"></span>
            </span>
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($topSellingProducts as $product)
                @foreach ($product->product_meta as $meta) <!-- Lặp qua từng meta của sản phẩm -->
                    <div class="flex flex-col text-center border border-gray-300 rounded-lg p-2 transition-all duration-500 hover:shadow-2xl hover:border-gray-400 transform hover:-translate-y-2 group">
                        <div class="relative overflow-hidden">
                            <div class="image-container">
                                <img src="{{ asset($product->primary_image) }}" alt="PRODUCT_IMAGE_ALT"
                                    class="img-primary h-64 transition-all duration-700 group-hover:scale-110" />
                                <img src="{{ asset($product->second_image) }}" alt="PRODUCT_IMAGE_ALT 2"
                                    class="img-secondary h-64 transition-all duration-700 absolute inset-0 opacity-0 group-hover:opacity-100" />
                                
                                <!-- Overlay buttons -->
                                <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center">
                                    <div class="flex gap-2 transform translate-y-full group-hover:translate-y-0 transition-all duration-500">
                                        <a href="/detail/{{ $product->id }}" class="bg-white p-2 rounded-full hover:bg-gray-200 transition-all duration-300 transform hover:scale-110">
                                            <i class="fas fa-eye text-gray-800"></i>
                                        </a>
                                        <button class="bg-white p-2 rounded-full hover:bg-gray-200 transition-all duration-300 transform hover:scale-110">
                                            <i class="fa-solid fa-cart-shopping text-gray-800"></i>
                                        </button>
                                        <form action="{{ route('add.favorite', $product->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-white p-2 rounded-full hover:bg-gray-200 transition-all duration-300 transform hover:scale-110">
                                                @if(auth()->check() && auth()->user()->favorite_product->contains('id_product', $product->id))
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
                                @foreach ($product->productcolor as $color)
                                    {{ $color->color['name_color'] }}@if(!$loop->last), @endif
                                @endforeach
                            </p>
                        </div>
                        <div class="flex justify-center gap-3">
                            <p class="text-sm text-gray-600">Kích thước:</p>
                            <p class="text-sm text-gray-800">
                                @foreach ($product->productsize as $size)
                                    {{ $size->size['name_size'] }}@if(!$loop->last), @endif
                                @endforeach
                            </p>
                        </div>
                        <h3 class="mt-2 font-semibold text-gray-800 truncate hover:text-gray-600 transition-all duration-300" >
                            <p>{{ $product->name }}</p>
                        </h3>
                        <!-- Kiểm tra xem có sale hay không -->
                        @if($meta->product_sale == 'sale') <!-- Nếu sản phẩm có sale -->
                            <div class="flex flex-col items-center gap-1">
                                <p class="text-gray-500 line-through text-sm">{{ number_format($meta['price']) }} VND</p>
                                <div class="flex items-center gap-2">
                                    <span class="text-red-600 font-bold text-lg">{{ number_format($meta['price_sale']) }} VND</span>
                                    <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow-md animate-pulse">SALE</span>
                                </div>
                            </div>
                        @elseif($meta->product_sale == 'no-sale') <!-- Nếu sản phẩm không có sale -->
                            <div class="flex flex-col items-center gap-1">
                                <p class="text-gray-800 font-bold text-lg">{{ number_format($meta['price']) }} VND</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
@endsection
