@extends('layout.layoutClient')

@section('title')
    Search
@endsection

@section('body')
<div class="container mx-auto py-8 max-w-7xl">
    <div class="flex justify-between space-x-8">
        <!-- Left Sidebar -->
        <div class="w-1/4">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Danh mục sản phẩm</h3>
                @foreach ($result_category as $category)
                    <div class="mt-3">
                        <a href="{{ route('product.showProducts', $category['id']) }}" 
                           class="block text-gray-600 hover:text-black transition duration-150 px-4 py-2.5 rounded-lg hover:bg-gray-50 border border-transparent hover:border-gray-200">
                            {{ $category->name }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-1/2">
            <div class="flex items-center space-x-3 mb-8">
                <h3 class="text-lg font-semibold text-gray-800">Từ khoá tìm kiếm:</h3>
                <span class="px-4 py-1.5 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                    "{{ $query }}"
                </span>
            </div>

            <h3 class="text-lg font-semibold text-gray-800 mb-6">Kết quả tìm kiếm</h3>

            @if($results->isEmpty())
                <div class="bg-gray-50 rounded-lg p-8 text-center">
                    <p class="text-gray-600">Không tìm thấy sản phẩm nào</p>
                </div>
            @else
                <div class="grid gap-6">
                    @foreach ($results as $product)
                        @foreach ($product->product_meta as $meta)
                            <div class="bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 group">
                                <div class="flex items-center p-4">
                                    <div class="flex-shrink-0 relative overflow-hidden">
                                        <img src="{{ asset($product->primary_image) }}" alt="{{ $product->name }}"
                                            class="h-48 w-48 object-cover transition-all duration-700 group-hover:scale-110">
                                        <img src="{{ asset($product->second_image) }}" alt="{{ $product->name }}"
                                            class="h-48 w-48 object-cover absolute inset-0 transition-all duration-700 opacity-0 group-hover:opacity-100">
                                            
                                        <!-- Overlay buttons -->
                                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center">
                                            <div class="flex gap-3 transform translate-y-full group-hover:translate-y-0 transition-all duration-500">
                                                <a href="/detail/{{ $product->id }}" class="bg-white p-2.5 rounded-full hover:bg-gray-200 transition-all duration-300 transform hover:scale-110">
                                                    <i class="fas fa-eye text-gray-800"></i>
                                                </a>
                                                <button class="bg-white p-2.5 rounded-full hover:bg-gray-200 transition-all duration-300 transform hover:scale-110">
                                                    <i class="fa-solid fa-cart-shopping text-gray-800"></i>
                                                </button>
                                                <form action="{{ route('add.favorite', $product->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-white p-2.5 rounded-full hover:bg-gray-200 transition-all duration-300 transform hover:scale-110">
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

                                    <div class="ml-6 flex-grow">
                                        <h4 class="font-semibold text-xl text-gray-800 hover:text-gray-600 transition-all duration-300 mb-3">
                                            {{ $product->name }}</h4>
                                        <div class="space-y-4">
                                            <div class="flex items-center">
                                                <span class="text-gray-500 mr-3 font-medium">Size:</span>
                                                <div class="flex gap-2">
                                                    @foreach ($product->productsize as $size)
                                                        <span class="text-gray-800 font-medium">{{ $size->size['name_size'] }}{{ !$loop->last ? ',' : '' }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="text-gray-500 mr-3 font-medium">Màu:</span>
                                                <div class="flex gap-2">
                                                    @foreach ($product->productcolor as $color)
                                                        <span class="text-gray-800 font-medium">{{ $color->color['name_color'] }}{{ !$loop->last ? ',' : '' }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @if($meta['product_sale'] == 'sale')
                                            <div class="mt-4">
                                                <div class="text-gray-600 line-through text-lg">{{ number_format($meta['price']) }} VND</div>
                                                <div class="flex items-center gap-3 mt-1">
                                                    <div class="text-red-600 font-bold text-xl">{{ number_format($meta['price_sale']) }} VND</div>
                                                    <span class="px-3 py-1 bg-red-100 text-red-600 text-sm font-semibold rounded-full animate-bounce">Sale</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-gray-900 font-bold text-xl mt-4">{{ number_format($meta['price']) }} VND</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Sidebar -->
        <div class="w-1/4">
           
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mt-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Từ khoá phổ biến</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach ($popularKeywords as $hashtag)
                        <form action="/search" method="GET" class="inline">
                            <input type="hidden" name="query" value="{{ $hashtag->keyword }}">
                            <button type="submit" 
                                    class="inline-block bg-gray-50 text-gray-700 rounded-full px-4 py-1.5 text-sm font-medium hover:bg-gray-100 transition duration-150">
                                #{{ $hashtag->keyword }}
                              
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
