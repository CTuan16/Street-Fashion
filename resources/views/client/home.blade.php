@extends('layout.layoutClient')

@section('title')
    Trang chủ
@endsection

@section('body')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    

    <div class="mx-auto max-w-7xl">
    <swiper-container class="shadow-lg hover:shadow-2xl transition-all duration-500 rounded-3xl overflow-hidden"
        navigation="true" 
        pagination="true" 
        loop="true" 
        autoplay-delay="3000" 
        autoplay-disable-on-interaction="false"
        style="--swiper-navigation-color: #4B5563; --swiper-navigation-size: 30px; --swiper-navigation-background-color: rgba(75, 85, 99, 0.8); --swiper-navigation-sides-offset: 20px; --swiper-navigation-border-radius: 50%; --swiper-pagination-color: #4B5563;">

        <swiper-slide class="rounded-3xl overflow-hidden">
            <div class="relative group overflow-hidden rounded-3xl">
                <img src="{{ asset('img/banner/banner01.webp') }}" alt="Banner 3" class="w-full h-[500px] object-cover transition-transform duration-700 transform group-hover:scale-110 rounded-3xl">
            </div>
        </swiper-slide>

        <swiper-slide class="rounded-3xl overflow-hidden">
            <div class="relative group overflow-hidden rounded-3xl">
                <img src="{{ asset('img/banner/banner02.webp') }}" alt="Banner 3" class="w-full h-[500px] object-cover transition-transform duration-700 transform group-hover:scale-110 rounded-3xl">
            </div>
        </swiper-slide>
         <swiper-slide class="rounded-3xl overflow-hidden">
            <div class="relative group overflow-hidden rounded-3xl">
                <img src="{{ asset('img/banner/banner03.webp') }}" alt="Banner 3" class="w-full h-[500px] object-cover transition-transform duration-700 transform group-hover:scale-110 rounded-3xl">
            </div>
        </swiper-slide>
         <swiper-slide class="rounded-3xl overflow-hidden">
            <div class="relative group overflow-hidden rounded-3xl">
                <img src="{{ asset('img/banner/banner04.webp') }}" alt="Banner 3" class="w-full h-[500px] object-cover transition-transform duration-700 transform group-hover:scale-110 rounded-3xl">
            </div>
        </swiper-slide>
         <swiper-slide class="rounded-3xl overflow-hidden">
            <div class="relative group overflow-hidden rounded-3xl">
                <img src="{{ asset('img/banner/banner05.webp') }}" alt="Banner 3" class="w-full h-[500px] object-cover transition-transform duration-700 transform group-hover:scale-110 rounded-3xl">
            </div>
        </swiper-slide>
        
    </swiper-container>
</div>

    <div class="pt-5 pb-5 max-w-7xl mx-auto">
        <!-- Sản Phẩm Nổi Bật -->
        <div class="flex justify-between items-center mt-5">
            <h2 class="text-2xl font-medium text-gray-800 relative group">
                Sản phẩm nổi bật
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gray-800 transition-all duration-500 group-hover:w-full"></span>
            </h2>
            <a href="{{ route('all.product.new') }}" class="relative inline-flex items-center group z-10">
                <div class="flex items-center gap-2 px-5 py-2.5 bg-gray-100 rounded-full transition-all duration-300 relative overflow-hidden">
                    <span class="text-gray-600 group-hover:text-white relative z-10">Xem tất cả</span>
                    <i class="fa-solid fa-hand-point-right group-hover:text-white relative z-10"></i>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 transform scale-x-0 origin-left transition-transform duration-300 group-hover:scale-x-100"></div>
                </div>
                <div class="absolute inset-0 border-2 border-transparent bg-gradient-to-r from-blue-500 to-purple-500 rounded-full transform scale-105 transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
            </a>
        </div>
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12">
                <swiper-container 
                style="--swiper-navigation-color: gray; --swiper-navigation-width: 10px; height: 480px"
                class="container mt-5 mx-auto max-w-full" 
                loop="true"
                autoplay-delay="1500"
                autoplay-disable-on-interaction="false"
                onmouseover="swiper.autoplay.stop()" 
                onmouseout="swiper.autoplay.start()"
                navigation="true"
                breakpoints='{
                    "640": {"slidesPerView": 1, "spaceBetween": 10}, 
                    "768": {"slidesPerView": 2, "spaceBetween": 20}, 
                    "1024": {"slidesPerView": 4, "spaceBetween": 30}
                }'
                >
                @foreach ($result_product_default as $product)
                    @foreach ($product->product_meta as $meta)
                    <swiper-slide style="height: 480px;">
                        <div class="flex flex-col text-center border border-gray-300 rounded-lg p-2 transition-all duration-500 hover:shadow-2xl hover:border-gray-400 transform hover:-translate-y-2 group" style="height: 480px">
                        <div class="relative overflow-hidden">
                            <!-- Product Images -->
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
                                    @if($user && $user->favorite_product->contains('id_product', $product->id))
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
                        <!-- Product Details -->
                        <div class="flex justify-center gap-3 mt-3">
                            <p class="text-sm text-gray-600">Màu sắc:</p>
                            <p class="text-sm text-gray-800">
                            @foreach ($product->productcolor as $color)
                                {{ $color->color['name_color'] }},
                            @endforeach
                            </p>
                        </div>
                        <div class="flex justify-center gap-3">
                            <p class="text-sm text-gray-600">Kích thước:</p>
                            <p class="text-sm text-gray-800">
                            @foreach ($product->productsize as $size)
                                {{ $size->size['name_size'] }},
                            @endforeach
                            </p>
                        </div>
                        <h3 class="mt-2 font-semibold text-gray-800 truncate hover:text-gray-600 transition-all duration-300">
                            <p>{{ $product->name }}</p>
                        </h3>
                        <p class="mt-2 text-gray-800 font-medium">{{ number_format($meta['price']) }} VND</p>
                        </div>
                    </swiper-slide>
                    @endforeach
                @endforeach
                </swiper-container>
            </div>
        </div>
<!-- Sản Phẩm bán chạy -->
<div class="pt-5 pb-5 max-w-7xl mx-auto">
    <div class="flex justify-between items-center mt-5">
        <h2 class="text-2xl font-medium text-gray-800 relative group">
            Sản phẩm bán chạy
            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gray-800 transition-all duration-500 group-hover:w-full"></span>
        </h2>
        <a href="{{ route('all.seller') }}" class="relative inline-flex items-center group z-10">
            <div class="flex items-center gap-2 px-5 py-2.5 bg-gray-100 rounded-full transition-all duration-300 relative overflow-hidden">
                <span class="text-gray-600 group-hover:text-white relative z-10">xem tất cả</span>
                <i class="fa-solid fa-hand-point-right group-hover:text-white relative z-10"></i>
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 transform scale-x-0 origin-left transition-transform duration-300 group-hover:scale-x-100"></div>
            </div>
            <div class="absolute inset-0 border-2 border-transparent bg-gradient-to-r from-blue-500 to-purple-500 rounded-full transform scale-105 transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
        </a>
    </div>
    <div class="grid grid-cols-12 gap-4 mt-5">
        @foreach ($topSellingProducts as $product)
            @foreach ($product->product_meta as $meta)
                <div class="col-span-12 md:col-span-4">
                    <div class="bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 group">
                        <div class="flex items-center p-2">
                            <div class="flex-shrink-0 relative overflow-hidden">
                                <img src="{{ asset($product->primary_image) }}" alt="PRODUCT_IMAGE_ALT"
                                    class="h-48 w-48 object-cover transition-all duration-700 group-hover:scale-110">
                                <img src="{{ asset($product->second_image) }}" alt="PRODUCT_IMAGE_ALT"
                                    class="h-48 w-48 object-cover absolute inset-0 transition-all duration-700 opacity-0 group-hover:opacity-100">
                                
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
                                                @if($user && $user->favorite_product->contains('id_product', $product->id))
                                                    <i class="fa-solid fa-heart text-red-500"></i>
                                                @else
                                                    <i class="fa-solid fa-heart text-gray-800"></i>
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="ml-4 flex-grow">
                                <h4 class="font-semibold text-lg text-gray-800 line-clamp-2 hover:text-gray-600 transition-all duration-300">
                                    {{ $product['name'] }}
                                </h4>
                                <p class="text-gray-600">Màu:
                                    @foreach ($product->productcolor as $color)
                                        {{ $color->color['name_color'] }}@if(!$loop->last), @endif
                                    @endforeach
                                </p>
                                <p class="text-gray-600">Kích thước:
                                    @foreach ($product->productsize as $size)
                                        {{ $size->size['name_size'] }}@if(!$loop->last), @endif
                                    @endforeach
                                </p>

                                <!-- Kiểm tra trạng thái sale -->
                              @if($meta->product_sale == 'sale') 
    <!-- Hiển thị giá sale -->
    <div class="text-gray-600 line-through">
        {{ number_format($meta['price']) }} VND
    </div>
    <div class="flex items-center gap-2">
        <div class="text-red-600 font-bold">{{ number_format($meta['price_sale']) }} VND</div>
        <span class="px-2 py-0.5 bg-red-100 text-red-600 text-xs font-semibold rounded-full animate-bounce">Sale</span>
    </div>
@elseif($meta->product_sale == 'no-sale') 
    <!-- Hiển thị giá gốc nếu không sale -->
    <div class="text-gray-600 font-bold">
        {{ number_format($meta['price']) }} VND
    </div>
@endif

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</div>



        <!-- Sản Phẩm Khuyến Mãi -->
        <div class="pt-5 pb-5 max-w-7xl mx-auto">
            <div class="flex justify-between items-center mt-5">
                <h2 class="text-2xl font-medium text-gray-800 relative group">
                    Sản phẩm khuyến mãi
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gray-800 transition-all duration-500 group-hover:w-full"></span>
                </h2>
                <a href="{{ route('all.product.sale') }}" class="relative inline-flex items-center group z-10">
                    <div class="flex items-center gap-2 px-5 py-2.5 bg-gray-100 rounded-full transition-all duration-300 relative overflow-hidden">
                        <span class="text-gray-600 group-hover:text-white relative z-10">Xem tất cả</span>
                        <i class="fa-solid fa-hand-point-right group-hover:text-white relative z-10"></i>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 transform scale-x-0 origin-left transition-transform duration-300 group-hover:scale-x-100"></div>
                    </div>
                    <div class="absolute inset-0 border-2 border-transparent bg-gradient-to-r from-blue-500 to-purple-500 rounded-full transform scale-105 transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
                </a>
            </div>
            <div class="grid grid-cols-12 gap-4 mt-5">
                @foreach ($result_product_sale as $product)
                    @foreach ($product->product_meta as $meta)
                        <div class="col-span-12 md:col-span-4">
                            <div class="bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 group">
                                <div class="flex items-center p-2">
                                    <div class="flex-shrink-0 relative overflow-hidden">
                                        <img src="{{ asset($product->primary_image) }}" alt="PRODUCT_IMAGE_ALT"
                                            class="h-48 w-48 object-cover transition-all duration-700 group-hover:scale-110">
                                        <img src="{{ asset($product->second_image) }}" alt="PRODUCT_IMAGE_ALT"
                                            class="h-48 w-48 object-cover absolute inset-0 transition-all duration-700 opacity-0 group-hover:opacity-100">
                                            
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
                                                        @if($user && $user->favorite_product->contains('id_product', $product->id))
                                                            <i class="fa-solid fa-heart text-red-500"></i>
                                                        @else
                                                            <i class="fa-solid fa-heart text-gray-800"></i>
                                                        @endif
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ml-4 flex-grow">
                                        <h4 class="font-semibold text-lg text-gray-800 line-clamp-2 hover:text-gray-600 transition-all duration-300">
                                            {{ $product['name'] }}
                                        </h4>
                                        <p class="text-gray-600">Màu:
                                            @foreach ($product->productcolor as $color)
                                                {{ $color->color['name_color'] }},
                                            @endforeach
                                        </p>
                                        <p class="text-gray-600">Kích thước:
                                            @foreach ($product->productsize as $size)
                                                {{ $size->size['name_size'] }},
                                            @endforeach
                                        </p>
                                        <div class="text-gray-600 line-through">{{ number_format($meta['price']) }} VND</div>
                                        <div class="flex items-center gap-2">
                                            <div class="text-red-600 font-bold">{{ number_format($meta['price_sale']) }} VND</div>
                                            <span class="px-2 py-0.5 bg-red-100 text-red-600 text-xs font-semibold rounded-full animate-bounce">Sale</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>

        <!-- Tất Cả Sản Phẩm -->
        <div class="pt-5 pb-5 max-w-7xl mx-auto">
            <div class="flex justify-between items-center mt-5">
                <h2 class="text-2xl font-medium text-gray-800 relative group">
                    Tất Cả Sản Phẩm
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gray-800 transition-all duration-500 group-hover:w-full"></span>
                </h2>
                <a href="{{ route('all.product') }}" class="relative inline-flex items-center group z-10">
                    <div class="flex items-center gap-2 px-5 py-2.5 bg-gray-100 rounded-full transition-all duration-300 relative overflow-hidden">
                        <span class="text-gray-600 group-hover:text-white relative z-10">Xem tất cả</span>
                        <i class="fa-solid fa-hand-point-right group-hover:text-white relative z-10"></i>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 transform scale-x-0 origin-left transition-transform duration-300 group-hover:scale-x-100"></div>
                    </div>
                    <div class="absolute inset-0 border-2 border-transparent bg-gradient-to-r from-blue-500 to-purple-500 rounded-full transform scale-105 transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mt-5">
                @foreach ($result_product as $product)
                    @foreach ($product->product_meta as $meta)
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
                                        {{ $color->color['name_color'] }},
                                    @endforeach
                                </p>
                            </div>
                            <div class="flex justify-center gap-3">
                                <p class="text-sm text-gray-600">Kích thước:</p>
                                <p class="text-sm text-gray-800">
                                    @foreach ($product->productsize as $size)
                                        {{ $size->size['name_size'] }},
                                    @endforeach
                                </p>
                            </div>
                            <h3 class="mt-2 font-semibold text-gray-800 truncate hover:text-gray-600 transition-all duration-300">
                                <p>{{ $product->name }}</p>
                            </h3>
                            <p class="mt-2 text-gray-800 font-medium">{{ number_format($meta['price']) }} VND</p>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>

    
    
   
</div>
<div class="relative bg-gray-900 overflow-hidden mb-4"> 
        <div class="width-full mx-auto">
            <div class="relative z-10 py-8 bg-gray-900 sm:py-12 lg:max-w-2xl lg:w-full">
                <main class="mx-auto max-w-7xl px-4 sm:px-6 ">
                    <div class="sm:text-center lg:text-left pl-20">
                        <h1 class="text-3xl tracking-tight font-bold text-white sm:text-4xl">
                            <span class="block transform transition-all duration-500 hover:scale-110">Khuyến mãi đặc biệt</span>
                            <span class="block text-red-500 animate-bounce">Giảm giá lên đến 50%</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-300 sm:text-lg">
                            Đừng bỏ lỡ cơ hội mua sắm với giá ưu đãi nhất!
                        </p>
                        <div class="mt-5 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="#" class="w-full flex items-center justify-center px-6 py-2 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-all duration-500 transform hover:scale-110">
                                    Mua ngay
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-48 w-full object-cover sm:h-56 lg:w-full lg:h-full transition-all duration-700 hover:scale-110" src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Shopping banner">
        </div>
    </div>

@endsection