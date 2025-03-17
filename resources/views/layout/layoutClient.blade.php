<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('Title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link
  rel="stylesheet"
  href="https://unpkg.com/swiper/swiper-bundle.min.css"
/>
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">

</head>
<body class="mt-auto">
    @include('client.block.header')
    <main>
    <!-- Zalo Chat Widget -->
    <div class="zalo-chat-widget fixed lg:bottom-4 lg:right-4 bottom-20 right-10 z-50 animate-bounce">
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
        @yield('body')
    </main>
    @include('client.block.footer')
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
</body>
</html>
