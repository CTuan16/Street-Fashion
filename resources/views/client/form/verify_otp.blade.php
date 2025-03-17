@extends('layout.layoutClient')
@section('title')
    Đăng nhập
@endsection
@section('body')
<div class="sm:mx-auto ">
    <h2 class="mt-6 text-center text-3xl font-bold md:text-white text-black">Nhập OTP</h2>
</div>
<div class="max-w-7xl mx-auto" >
    <div class="grid grid-cols-12 space-x-10  " >
        <div class=" col-span-3 flex justify-center items-center">
            <img style=" border-radius: 16px; height: 65vh" src="/img/Form/hinh2q.jpg" alt="Image 1" class="md:block hidden " />
        </div>
        <div class="min-h-full flex flex-col justify-center sm:px-6 lg:px-8 md:col-span-6 col-span-12">
            <img src="/img/Form/dn.png" 
                alt="Hình ảnh nền" 
                class="object-cover w-full h-full absolute inset-0 md:block hidden "
                style="z-index: -1;" />
                  <!-- Đảm bảo ảnh ở phía dưới -->
            <div class="mt-8 w-100 relative z-10"> <!-- Đặt z-index cao hơn cho nội dung -->
                <div class="py-8 px-4 sm:rounded-lg">
                    <form class="space-y-6" action="{{ route('verifyOtpForm') }}" method="POST">
                        @csrf
                        <div>
                            <label for="otp_code" class="block text-sm font-regular md:text-white text-black">Mã OTP</label>
                            <div class="mt-1">
                                <input
                                    id="otp_code"
                                    name="otp_code"
                                    type="text"
                                    value="{{ old('otp_code') }}"
                                    placeholder="Nhập mã OTP"
                                    
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                />
                                @error('otp_code')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    
                        <div>
                            <button
                                type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Xác nhận
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="md:block hidden col-span-3 justify-center items-center">
            <img style="border-radius: 16px; height: 65vh" src="/img/Form/hinh2q.jpg" alt="Image 1"  />
        </div>
    </div>
</div>
@endsection