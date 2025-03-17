<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    @include('admin.layoutv2.layout.head')
    @stack('style')
</head>
<body class="app admin dashboard invoices-total-manual user-id-1 chrome pjax">
@include('admin.layoutv2.layout.header')
@include('admin.layoutv2.layout.aside')
<div id="pjax-container">
        @yield('content')
</div>

@include('admin.layoutv2.layout.scripts')
@stack('script')
</body>

</html>
