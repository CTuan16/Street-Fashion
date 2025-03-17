@extends('layout.layoutClient')
@section('title')
    Đăng ký
@endsection
@section('body')
<div class="sm:mx-auto ">
    <h2 class="mt-6 text-center text-3xl font-bold md:text-white text-black ">Đăng ký</h2>
</div>
<div class="max-w-7xl mx-auto" >
    <div class="grid grid-cols-12 space-x-10  " >
        <div class=" col-span-3 flex justify-center items-center">
            <img style=" border-radius: 16px; height: 80vh" src="/img/Form/hinh1dk.jpg" alt="Image 1"  class="md:block hidden" />
        </div>
        <div class="min-h-full flex flex-col justify-center sm:px-6 lg:px-8 md:col-span-6 col-span-12">
            <img src="/img/Form/dn.png" 
                alt="Hình ảnh nền" 
                class="object-cover w-full h-100 absolute inset-0 md:block hidden "
                style="z-index: -1;" />
                  <!-- Đảm bảo ảnh ở phía dưới -->
           
            <div class=" w-100 relative z-10"> <!-- Đặt z-index cao hơn cho nội dung -->
                <div class=" px-4 sm:rounded-lg">
                    <form class="space-y-3" action="{{ route('register') }}" method="POST">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-regular md:text-white text-black">Họ và tên</label>
                            <div class="mt-1">
                                <input id="name" name="name" type="text" placeholder="Vui lòng nhập họ và tên" 
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
                                @error('name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    
                        <div>
                            <label for="email" class="block text-sm font-regular md:text-white text-black">Email</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="text" placeholder="Vui lòng nhập email" 
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
                                @error('email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    
                        <div>
                            <label for="password" class="block text-sm font-regular md:text-white text-black">Mật khẩu</label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" placeholder="Vui lòng nhập mật khẩu" 
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
                                @error('password')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    
                        <div>
                            <label for="confirm_password" class="block text-sm font-regular md:text-white text-black">Xác nhận mật khẩu</label>
                            <div class="mt-1">
                                <input id="confirm_password" name="password_confirmation" type="password" placeholder="Vui lòng xác nhận mật khẩu" 
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
                            </div>
                        </div>
                    
                        <div>
                            <label for="phone" class="block text-sm font-regular md:text-white text-black">Số điện thoại</label>
                            <div class="mt-1">
                                <input id="phone" name="phone" type="number" placeholder="Vui lòng nhập số điện thoại" 
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
                                @error('phone')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    
                        <div>
                            <label for="date" class="block text-sm font-regular md:text-white text-black">Ngày sinh</label>
                            <div class="mt-1">
                                <input id="date" name="date" type="date" 
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
                                @error('date')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    
                        <div class="flex items-center gap-2">
                            <div class="flex items-center">
                                <input id="gender_male" name="gender" type="radio" value="Nam" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"/>
                                <label for="gender_male" class="ml-2 block text-sm md:text-white text-black">Nam</label>
                            </div>
                            <div class="flex items-center">
                                <input id="gender_female" name="gender" type="radio" value="Nữ" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"/>
                                <label for="gender_female" class="ml-2 block text-sm md:text-white text-black">Nữ</label>
                            </div>

                            @error('gender')
                             <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    
                        <div>
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Đăng ký
                            </button>
                            
                        </div>
                        <div class="md:text-white text-black text-center ">

                            <a class="hover:text-red-600 hover:underline" href="{{ route('login') }}">Đã có tài khoản</a>
                        </div>
                    </form>
                    
        
                        
                        <div class="mt-6">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">Hoặc</span>
                            </div>
                        </div>
        
                        <div class="mt-6 grid grid-cols-3 gap-3">
                            <div>
                                <a
                                    href="#"
                                    class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                >
                                    <span class="sr-only">Sign in with Facebook</span>
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            fill-rule="evenodd"
                                            d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </a>
                            </div>
        
                            <div>
                                <a
                                    href="{{ route('google-login')}}"
                                    class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                >
                                    <span class="sr-only">Sign in with Google</span>
                                    <svg class="w-5 h-5" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="#4285F4" d="M22.48 12.273c0-.638-.057-1.25-.157-1.838H12v3.474h5.885c-.254 1.368-1.017 2.527-2.164 3.296v2.738h3.504c2.045-1.884 3.226-4.655 3.226-7.67z"/>
                                        <path fill="#34A853" d="M12 24c2.94 0 5.41-.975 7.212-2.638l-3.504-2.738c-.972.652-2.215 1.038-3.708 1.038-2.855 0-5.272-1.928-6.135-4.525H2.237v2.838C4.038 21.525 7.662 24 12 24z"/>
                                        <path fill="#FBBC05" d="M5.865 14.137A7.41 7.41 0 015.5 12c0-.738.132-1.452.364-2.137V7.025H2.237A11.977 11.977 0 000 12c0 1.967.477 3.82 1.308 5.475l3.557-2.838z"/>
                                        <path fill="#EA4335" d="M12 4.8c1.598 0 3.033.55 4.166 1.623l3.125-3.125C17.403 1.5 14.943 0 12 0 7.662 0 4.038 2.475 2.237 6.025l3.627 2.838C6.728 6.728 9.145 4.8 12 4.8z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-span-3 flex justify-center items-center">
            <img style="border-radius: 16px; height: 80vh" src="/img/Form/hinh2dk.jpg" alt="Image 1"  class="md:block hidden "/>
        </div>
    </div>
</div>
@endsection
