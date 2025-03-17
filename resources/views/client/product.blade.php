@extends('layout.layoutClient')

@section('title')
    Sản phẩm
@endsection

@section('body')
<!-- Zalo Chat Widget -->
<div class="zalo-chat-widget fixed bottom-4 right-4 z-50 animate-bounce">
    <a href="https://zalo.me/0362654805" target="_blank" 
        class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white p-3 rounded-full shadow-xl 
        transition-all duration-500 transform hover:scale-125 hover:rotate-12
        relative before:absolute before:inset-0 before:rounded-full before:bg-blue-400 before:animate-ping before:opacity-75">
        <div class="relative">
            <img src="https://page.widget.zalo.me/static/images/2.0/Logo.svg" alt="Zalo Chat" class="w-8 h-8">
            <div class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
        </div>
        <div class="absolute -top-10 right-0 bg-white text-gray-800 px-3 py-1 rounded-lg shadow-md 
            opacity-0 transition-opacity duration-300 hover:opacity-100 whitespace-nowrap">
            Chat với chúng tôi!
        </div>
    </a>
</div>


<div class="sm:mx-auto">
    {{-- Breadcrumb Navigation (optional) --}}
</div>

<div class="max-w-7xl mx-auto mb-8">
    <div class="grid grid-cols-12 gap-10">
        <!-- Phần ảnh bên trái -->
        <div class="col-span-2 mt-10">
            <nav class="bg-white p-3 rounded-lg shadow-sm mb-4">
                <ol class="flex flex-wrap items-center text-xs">
                    <li>
                        <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-600 transition-colors">Trang chủ</a>
                    </li>
                    <li class="mx-1 text-gray-400">/</li>
                    <li>
                        <a href="{{ url('/product/' . $category->id) }}" class="text-gray-600 hover:text-gray-600 transition-colors">{{ $category->name }}</a>
                    </li>
                    @if (isset($subcategory))
                        <li class="mx-1 text-gray-400">/</li>
                        <li>
                            <a href="{{ url('/product/' . $category->id . '/' . $subcategory->id) }}" class="text-gray-600 hover:text-gray-600 transition-colors">{{ $subcategory->name }}</a>
                        </li>
                    @endif
                </ol>
            </nav>
            <!-- anh -->
            <div class="flex flex-col space-y-8">
                <div class="group relative overflow-hidden rounded-xl shadow-lg">
                    <img 
                        class="h-[50vh] w-full object-cover transform transition duration-500 group-hover:scale-110" 
                        src="{{ asset('img/Form/hinh1dk.jpg') }}" 
                        alt="Image 1"
                    />
                    <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>

               
                <div class="group relative overflow-hidden rounded-xl shadow-lg">
                    <img 
                        class="h-[50vh] w-full object-cover transform transition duration-500 group-hover:scale-110" 
                        src="{{ asset('img/Form/hinh2dk.jpg') }}" 
                        alt="Image 2"
                    />
                    <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
            </div>
        </div>
        <!-- Phần sản phẩm bên phải -->
        <div class="col-span-10 mt-10">
            {{-- <div class="container mx-auto mt-3 text-center">
                <h2 class="text-3xl font-bold text-gray-500">{{ $category->name }}</h2>
            </div> --}}

            {{-- Hiển thị danh mục con --}}
            <div class="mt-5 flex flex-wrap justify-center gap-4">
                @foreach ($category->category_child as $subcategory)
                <a href="/product/{{ $category->id }}/{{ $subcategory->id }}" class="px-4 py-2 bg-white text-gray-800 rounded-md border border-gray-200 hover:border-gray-500 hover:bg-gray-50">
                    {{ $subcategory->name }}
                </a>
                @endforeach
            </div>
            
            <!-- Phần hiển thị sản phẩm -->
            <div class="bg-white rounded-lg shadow-md mt-6">
                <div class="mt-10 border border-gray-200 rounded-lg">
                    <section class="lg:max-w-8xl lg:mx-auto lg:px-8">
                        <div class="relative w-full pb-6 mb-6 overflow-x-auto">
                            <div role="list" class="mx-4 inline-flex flex-wrap justify-center lg:grid lg:grid-cols-3 lg:gap-x-8 mt-10">
                                @foreach ($products as $product)
                                    @foreach ($product->product_meta as $product_meta)
                                        <div class="flex flex-col text-center border border-gray-300 rounded-lg p-2 transition-all duration-500 hover:shadow-2xl hover:border-gray-400 transform hover:-translate-y-2 group mb-5">
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
                                                        {{ $color->color['name_color'] }}@if (!$loop->last), @endif
                                                    @endforeach
                                                </p>
                                            </div>
                                            <div class="flex justify-center gap-3">
                                                <p class="text-sm text-gray-600">Kích thước:</p>
                                                <p class="text-sm text-gray-800">
                                                    @foreach ($product->productsize as $size)
                                                        {{ $size->size['name_size'] }}@if (!$loop->last), @endif
                                                    @endforeach
                                                </p>
                                            </div>
                                            <h3 class="mt-2 font-semibold text-gray-800 truncate hover:text-gray-600 transition-all duration-300">
                                                <p>{{ $product->name }}</p>
                                            </h3>
                                            @if($product_meta->product_sale == 'sale')
                                                <div class="flex flex-col items-center gap-1">
                                                    <p class="text-gray-500 line-through text-sm">{{ number_format($product_meta->price) }} VND</p>
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-red-600 font-bold text-lg">{{ number_format($product_meta->price_sale) }} VND</span>
                                                        <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow-md animate-pulse">SALE</span>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="mt-1 text-gray-900">{{ number_format($product_meta->price) }} VND</p>
                                            @endif
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        <!-- Pagination -->
                        {{-- phân trang --}}
                        <div class="bg-white mt-10 flex px-4 py-3 items-center justify-between border-t border-gray-200 sm:px-6">
                            <div class="hidden flex flex-col sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                        @if ($products->onFirstPage())
                                            <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400">&lt;</span>
                                        @else
                                            <a href="{{ $products->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">&lt;</a>
                                        @endif

                                        @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                            <a href="{{ $url }}" 
                                               aria-current="{{ $products->currentPage() == $page ? 'page' : '' }}"
                                               class="{{ $products->currentPage() == $page ? 'z-10 bg-gray-50 border-gray-500 text-gray-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50' }} relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                                {{ $page }}
                                            </a>
                                        @endforeach

                                        @if ($products->hasMorePages())
                                            <a href="{{ $products->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">&gt;</a>
                                        @else
                                            <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400">&gt;</span>
                                        @endif
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
