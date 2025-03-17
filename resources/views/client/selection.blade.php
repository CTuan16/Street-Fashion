@extends('layout.layoutClient')

@section('title')
    Street Fashion Blog - Xu Hướng Thời Trang Đường Phố
@endsection

@section('body')
<div class="container mx-auto p-6 max-w-5xl">

    <!-- Blog Post Section -->
    <div class="flex flex-col lg:flex-row space-x-8">
        <!-- Left Section: Blog Post Content -->
        <div class="lg:w-2/3 w-full">
            <!-- Title and Dropdown -->
            <div class="flex justify-between items-center mb-4">
                <div class="text-xl font-semibold text-gray-800">
                    Bài viết
                </div>
                
                <!-- Dropdown for selecting "Mới nhất" and "Cũ nhất" -->
                <div>
                    <select id="sort-date" class="form-select w-full sm:w-auto rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 text-gray-600" onchange="sortPosts(this.value)">
                        <option value="" disabled selected>Sắp xếp</option>
                        <option value="newest">Mới nhất</option>
                        <option value="oldest">Cũ nhất</option>
                    </select>
                    
                </div>
                
            </div>
            
            <!-- Post 1 -->
            <div class="posts-container " >
           @foreach ($posts as $post)
           <div class="border border-gray-300 p-4 rounded-lg shadow-md mb-6" data-date="{{ $post->created_at->format('Y-m-d H:i:s') }}">
            <div class="flex flex-col">
                <img src="{{ asset($post->image) }}" alt="Fashion Post Image" class="w-full rounded-lg shadow-lg mb-4">

                <!-- Author Information -->
                <div class="flex items-center justify-between mb-4">
                    <!-- Logo và thông tin -->
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('img/logo.png') }}" alt="Author Logo" class="w-12 h-12 rounded-full border-2 border-gray-300">
                        <div class="text-sm">
                            <div class="font-semibold text-gray-800">Street Fashion</div>
                            <div class="text-gray-600">{{ $post->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                
                    <!-- Nút "Xem tất cả" -->
                    <a href="{{ route('home') }}" class="relative inline-flex items-center group z-10">
                        <div class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full transition-all duration-300 relative overflow-hidden">
                            <span class="text-white text-sm font-medium relative z-10">Ghé Cửa hàng</span>
                            <i class="fa-solid fa-hand-point-right text-white relative z-10"></i>
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 transform scale-x-100 origin-left transition-transform duration-300"></div>
                        </div>
                        <div class="absolute inset-0 border-2 border-transparent bg-gradient-to-r from-pink-500 to-purple-500 rounded-full transform scale-105 transition-all duration-300 opacity-100"></div>
                    </a>
                    
                </div>
                

                <!-- Post Title and Content -->
                <div class="text-gray-600 mb-2">
                    <p class="text-lg">{{ $post->title }}</p>
                </div>
                <p class="text-gray-800 ">
                    {{ $post->content }}
                </p>
                <a href="#" class="text-blue-500 hover:text-blue-700">Xem thêm</a>
            </div>
        </div>
           @endforeach
           </div>

            <!-- Post 2 -->
            
        </div>

        <!-- Right Section: Hashtags and Categories -->
        <div class="lg:w-1/3 w-full flex flex-col space-y-6">
            <!-- Hashtags Section -->
            <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                <div class="font-semibold text-lg text-gray-800 mb-4">Hashtags</div>
                <div class="flex flex-wrap gap-2">
                  @foreach ($popularKeywords as $keyword)
                        <span class="text-sm text-gray-700 bg-gray-200 px-3 py-1 rounded-full">#{{ $keyword->keyword }}</span>
                    @endforeach
                  
                </div>
            </div>

            <!-- Categories Section -->
            <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                <div class="font-semibold text-lg text-gray-800 mb-2">Categories</div>
                
                @php
                    // Mảng ánh xạ tên danh mục với ảnh mặc định
                    $categoryImages = [
                        'jacket' => 'img/banner/category02.png',
                        't-shirt' => 'img/banner/category03.png',
                        'short' => 'img/banner/category04.png',
                        'so-mi' => 'img/banner/category01.png',
                        'phu-kien' => 'img/banner/category05.png',
                    ];
                @endphp
                
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($result_category as $category)
                        @php
                            // Chuyển tên danh mục về chữ thường để khớp với key trong mảng
                       
                            
                        @endphp
                        <div class="relative">
                            <a href="{{ route('product.showProducts', $category['id']) }}" class="block">
                                <!-- Sử dụng thẻ img thay vì background-image -->
                                <img src="{{ asset($categoryImages[$category->slug] ?? 'img/banner/category01.png') }}" alt="{{ $category->name }}" class="w-full h-32 object-cover rounded-lg">
                                
                                <!-- Text overlay với nền -->
                                <div class="flex items-center justify-center bg-black bg-opacity-5 text-grey-700 text-sm font-semibold rounded-lg">
                                    <a href="{{ route('product.showProducts', $category['id']) }}" class="block">{{ $category->slug }}</a>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            
            </div>
            
        </div>
    </div>

</div>

@endsection
<script>
             
    function sortPosts(sortBy) {
const postsContainer = document.querySelector('.posts-container');
const posts = Array.from(postsContainer.children);

posts.sort((a, b) => {
const dateA = new Date(a.dataset.date); // Ngày bài viết A
const dateB = new Date(b.dataset.date); // Ngày bài viết B

if (sortBy === 'newest') {
   return dateB - dateA; // Sắp xếp theo ngày mới nhất
} else if (sortBy === 'oldest') {
   return dateA - dateB; // Sắp xếp theo ngày cũ nhất
}
});

// Xóa các bài viết hiện tại và thêm bài viết đã sắp xếp lại
while (postsContainer.firstChild) {
postsContainer.removeChild(postsContainer.firstChild);
}
posts.forEach(post => postsContainer.appendChild(post));
}



</script>