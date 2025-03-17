@extends('layout.layoutClient')
@section('title')
    Đăng nhập
@endsection
@section('body')
<div class="sm:mx-auto ">
    <h2 class="mt-6 text-center text-3xl font-bold text-white ">Xác nhận mật khẩu</h2>
</div>
<div class="max-w-7xl mx-auto" >
    <div class="grid grid-cols-12 space-x-10  " >
        <div class=" col-span-3 flex justify-center items-center">
            <img style=" border-radius: 16px; height: 65vh" src="/img/Form/hinh1xn.jpg" alt="Image 1"  />
        </div>
        <div class="min-h-full flex flex-col justify-center sm:px-6 lg:px-8 col-span-6">
            <img src="/img/Form/dn.png" alt="Hình ảnh nền" class="object-cover w-full h-full absolute inset-0" style="z-index: -1;" />
            <!-- Đảm bảo ảnh ở phía dưới -->
        
            <div class="mt-8 w-100 relative z-10"> <!-- Đặt z-index cao hơn cho nội dung -->
                <div class="py-8 px-4 sm:rounded-lg">
                    <form class="space-y-6" action="{{ route('confirm') }}" method="POST">
                        @csrf
                        <div>
                            <label for="password" class="block text-sm font-regular text-white">Mật khẩu</label>
                            <div class="mt-1">
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autocomplete="current-password"
                                    placeholder="Vui lòng nhập mật khẩu"
                                    
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                />
                                @error('password')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="confirm_password" class="block text-sm font-regular text-white">Xác nhận mật khẩu</label>
                            <div class="mt-1">
                                <input
                                    id="confirm_password"
                                    name="confirm_password"
                                    type="password"
                                    autocomplete="current-password"
                                    placeholder="Vui lòng xác nhận mật khẩu"
                                    
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                />
                                @error('confirm_password')
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
        
        
        <div class="col-span-3 flex justify-center items-center">
            <img style="border-radius: 16px; height: 65vh" src="/img/Form/hinh2xn.jpg" alt="Image 1"  />
        </div>
    </div>
</div>
@endsection
