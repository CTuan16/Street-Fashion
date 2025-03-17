<!DOCTYPE html>
<html lang="en">
<!-- Top Header Bar -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<link rel="stylesheet" href="/css/detail/form_size.css">
<header class="bg-black text-white py-2 transition-all duration-300 hover:bg-gray-900 ">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6">
        <div>
            <a href="#" class="flex items-center space-x-2 hover:text-gray-300 transition-all duration-300 transform hover:scale-105">
                <i class="fa-solid fa-house text-lg"></i>
                <span class="font-medium">Street Fashion</span>
            </a>
        </div>
        <div class="flex items-center space-x-4 text-sm">
            <span class="flex items-center hover:text-gray-300 transition-all duration-300">
                <i class="fa-solid fa-phone mr-2 animate-bounce"></i>
                Hotline: 0906.880.960
            </span>
            <span class="text-gray-400">•</span>
            <a href="#" class="hover:text-gray-300 transition-all duration-300 transform hover:translate-x-1">Hỗ trợ trực tuyến</a>
        </div>
    </div>
</header>

<body>

<!-- Main Navigation -->
<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-8 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center md:hidden">
                <a href="/" class="transition-all duration-300 transform hover:scale-110">
                    <img class="w-24" src="{{ asset('/img/logo.png') }}">
                </a>
            </div>
            <!-- Mobile Menu Button -->
            <button id="menu-btn" class="md:hidden text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>

            <!-- Mobile Dropdown Menu -->
            <div id="mobile-menu" class="hidden bg-white md:hidden">
                <a href="{{ route('favorite.product') }}" class="block px-6 py-3 text-base text-gray-700 hover:bg-gray-100">Sản phẩm yêu thích</a>
                <a href="{{ route('size.selection') }}" class="block px-6 py-3 text-base text-gray-700 hover:bg-gray-100">Gợi ý outfit</a>
                @if (Auth::User())
                    <div class="py-2">
                        <a href="{{ route('profile') }}" class="block px-6 py-3 text-base text-gray-700 hover:bg-gray-50 transition-all duration-300 hover:translate-x-1">Hồ Sơ</a>
                    </div>
                    <div class="py-2">
                        <a href="{{ route('purchase.history') }}" class="block px-6 py-3 text-base text-gray-700 hover:bg-gray-50 transition-all duration-300 hover:translate-x-1">Lịch sử mua hàng</a>
                    </div>
                    @if (Auth::check() && Auth::user()->role_id === 1)
                        <div class="py-2">
                            <a href="{{ route('admin') }}" class="block px-6 py-3 text-base text-gray-700 hover:bg-gray-50 transition-all duration-300 hover:translate-x-1">Admin</a>
                        </div>
                    @endif
                    <div class="py-2">
                        <a href="/logout" class="block px-6 py-3 text-base text-gray-700 hover:bg-gray-50 transition-all duration-300 hover:translate-x-1">Đăng xuất</a>
                    </div>
                @else
                    <div class="py-2">
                        <a href="/register" class="block px-6 py-3 text-base text-gray-700 hover:bg-gray-50 transition-all duration-300 hover:translate-x-1">Đăng ký</a>
                    </div>
                    <div class="py-2">
                        <a href="/login" class="block px-6 py-3 text-base text-gray-700 hover:bg-gray-50 transition-all duration-300 hover:translate-x-1">Đăng nhập</a>
                    </div>
                @endif
            </div>
            
            <!-- Navigation Links -->
            <div class="hidden md:flex items-center justify-between w-full space-x-8">
                <div class="flex items-center">
                    <a href="/" class="transition-all duration-300 transform hover:scale-110">
                        <img class="w-24" src="{{ asset('/img/logo.png') }}">
                    </a>
                </div>

                <div class="flex items-center space-x-8">
                    <div class="relative">
                        <button class="flex items-center space-x-2 px-4 py-3 text-base font-medium text-gray-700 hover:text-black transition-all duration-300 border-b-2 border-transparent hover:border-black" onclick="toggleDropdown('shopDropdown')">
                            <span>Cửa hàng</span>
                            <i class="fa-solid fa-caret-down text-gray-400 transition-transform duration-300"></i>
                        </button>

                        <!-- Dropdown Menu for Shop -->
                        <div id="shopDropdown" class="hidden absolute left-0 mt-2 w-64 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none transform origin-top transition-all duration-300" style="z-index: 1200">
                            @foreach ($result_category as $category)
                            <a href="{{ route('product.showProducts', $category['id']) }}" class="block hover:bg-gray-50 transition-all duration-300">
                                <div class="px-6 py-3 flex justify-between items-center group">
                                    <span class="text-base text-gray-800 group-hover:text-black">{{$category['name']}}</span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform transition-transform duration-300 group-hover:translate-x-1">
                                        <path d="M8 4L16 12L8 20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('favorite.product') }}" class="text-base text-gray-700 hover:text-gray-900 font-medium transition-all duration-300 border-b-2 border-transparent hover:border-black">Sản phẩm yêu thích</a>
                    <a href="{{ route('size.selection') }}" class="text-base text-gray-700 hover:text-black font-medium transition-all duration-300 border-b-2 border-transparent hover:border-black">Gợi ý outfit</a>
                </div>

                <!-- Search Bar -->
                <div class="relative w-1/3">
                    <form action="/search" method="GET" class="relative">
                        <input type="text" 
                            name="query" 
                            placeholder="Nhập từ khoá tìm kiếm" 
                            class="w-full py-3 px-6 text-base rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent transition-all duration-300"
                        >
                        <button type="submit" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-all duration-300">
                            <i class="fa-solid fa-magnifying-glass text-lg hover:scale-110 transform"></i>
                        </button>
                    </form>
                </div>

                <!-- Right Icons -->
                <div class="flex items-center space-x-8">
                    <a href="#" class="text-gray-500 hover:text-gray-700 transition-all duration-300 border-b-2 border-transparent hover:border-black">
                        <i class="fa-solid fa-bell text-xl"></i>
                    </a>

                    <a href="{{ route('cart') }}" class="text-gray-500 hover:text-gray-700 transition-all duration-300 border-b-2 border-transparent hover:border-black">
                        <i class="fa-solid fa-cart-shopping text-xl"></i>
                    </a>

                    <!-- User Icon with Dropdown -->
                    <div class="relative">
                        <button class="hover:text-gray-700 inline-flex items-center text-gray-500 transition-all duration-300 border-b-2 border-transparent hover:border-black" onclick="toggleDropdown('userDropdown')">
                            @if (Auth::User())
                                @if (Auth::User()->google_id)
                                    <img src="{{ Auth::User()->avatar }}" 
                                        alt="User avatar" 
                                        class="w-9 h-9 rounded-full ring-2 ring-gray-200 object-cover transition-all duration-300 hover:ring-gray-400"
                                    >
                                @elseif (Auth::User()->avatar && Auth::User()->avatar != 'no_avt.jpg')
                                    <img src="{{ asset('img/avt/' . Auth::User()->avatar) }}"
                                        alt="User avatar"
                                        class="w-9 h-9 rounded-full ring-2 ring-gray-200 object-cover transition-all duration-300 hover:ring-gray-400"
                                    >
                                @else
                                    <img src="{{ asset('img/avt/no_avt.jpg') }}"
                                        alt="User avatar"
                                        class="w-9 h-9 rounded-full ring-2 ring-gray-200 object-cover transition-all duration-300 hover:ring-gray-400"
                                    >
                                @endif
                            @else
                                <i class="fa-solid fa-user text-xl"></i>
                            @endif
                        </button>

                        <!-- User Dropdown Menu -->
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none transform origin-top transition-all duration-300" style="z-index: 9999;">
                            @if (Auth::User())
                                <div class="py-1">
                                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-50 transition-all duration-300 hover:translate-x-1">Hồ Sơ</a>
                                </div>
                                <div class="py-1">
                                    <a href="{{ route('purchase.history') }}" class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-50 transition-all duration-300 hover:translate-x-1">Lịch sử mua hàng</a>
                                </div>
                                @if (Auth::check() && Auth::user()->role_id === 1)
                                    <div class="py-1">
                                        <a href="{{ route('admin') }}" class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-50 transition-all duration-300 hover:translate-x-1">Admin</a>
                                    </div>
                                @endif
                                <div class="py-1">
                                    <a href="/logout" class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-50 transition-all duration-300 hover:translate-x-1">Đăng xuất</a>
                                </div>
                            @else
                                <div class="py-1">
                                    <a href="/register" class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-50 transition-all duration-300 hover:translate-x-1">Đăng ký</a>
                                </div>
                                <div class="py-1">
                                    <a href="/login" class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-50 transition-all duration-300 hover:translate-x-1">Đăng nhập</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

</body>
</html>

<script src="https://kit.fontawesome.com/e7db34f14d.js" crossorigin="anonymous"></script>
<script>
    function toggleDropdown(dropdownId) {
        const dropdownMenu = document.getElementById(dropdownId);
        dropdownMenu.classList.toggle('hidden');
        
        // Add slide animation
        if (!dropdownMenu.classList.contains('hidden')) {
            dropdownMenu.style.opacity = '0';
            dropdownMenu.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                dropdownMenu.style.opacity = '1';
                dropdownMenu.style.transform = 'translateY(0)';
            }, 50);
        }
    }

    // Close dropdowns if clicking outside
    window.addEventListener('click', function(event) {
        const dropdownMenus = document.querySelectorAll('.absolute');
        dropdownMenus.forEach(menu => {
            const button = menu.previousElementSibling;
            if (!button.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    });

    // Add scroll effect for navbar
    window.addEventListener('scroll', function() {
        const nav = document.querySelector('nav');
        if (window.scrollY > 0) {
            nav.classList.add('shadow-lg');
            nav.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
        } else {
            nav.classList.remove('shadow-lg');
            nav.style.backgroundColor = 'white';
        }
    });

    // Toggle Mobile Menu
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
</script>
