@extends('layout.layoutClient')
@section('title')
    Hồ sơ cá nhân
@endsection
@section('body')
<div class="max-w-4xl mx-auto my-12 p-10 border border-gray-300 rounded-xl shadow-xl bg-white">
    <h2 class="text-4xl font-bold text-gray-800 text-center mb-10">Hồ sơ cá nhân</h2>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-5 mb-8 rounded-lg">
            <p class="font-medium text-center">{{ session('success') }}</p>
        </div>
    @endif

    <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Left Column -->
            <div class="flex flex-col items-center space-y-8">
                <div class="relative">
                    @if($user->avatar && $user->avatar != 'no_avt.jpg')
                        <img src="{{ asset('img/avt/' . $user->avatar) }}" 
                             alt="Avatar" 
                             class="w-52 h-52 rounded-full border-4 border-indigo-300 shadow-2xl object-cover"
                             id="preview-avatar">
                    @else
                        <img src="{{ asset('img/avt/no_avt.jpg') }}" 
                             alt="Avatar" 
                             class="w-52 h-52 rounded-full border-4 border-indigo-300 shadow-2xl object-cover"
                             id="preview-avatar">
                    @endif
                    
                    <input type="file" name="avatar" accept="image/*" 
                            class="mt-4 block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100"
                           onchange="previewImage(this)">
                    @error('avatar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-gray-50 p-4 rounded-xl shadow-md w-full">
                    <p class="text-gray-600 text-sm text-center font-medium">
                        Dung lượng file tối đa 1 MB<br>
                        Định dạng: .JPEG, .PNG
                    </p>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <div>
                    <label for="name" class="text-gray-700 font-semibold mb-3 block text-lg">Họ và tên</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                           placeholder="Vui lòng nhập họ và tên" 
                           class="w-full px-5 py-4 rounded-xl border-2 @error('name') border-red-500 @else border-gray-300 @enderror focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                  
                </div>

                <div>
                    <label for="email" class="text-gray-700 font-semibold mb-3 block text-lg">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                           placeholder="Vui lòng nhập email" 
                           class="w-full px-5 py-4 rounded-xl border-2 @error('email') border-red-500 @else border-gray-300 @enderror focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="text-gray-700 font-semibold mb-3 block text-lg">Số điện thoại</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                           placeholder="Vui lòng nhập số điện thoại" 
                           class="w-full px-5 py-4 rounded-xl border-2 @error('phone') border-red-500 @else border-gray-300 @enderror focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-gray-700 font-semibold mb-3 block text-lg">Giới tính</label>
                    <div class="flex gap-8">
                        <label class="flex items-center space-x-4 cursor-pointer">
                            <input type="radio" name="gender" value="Nam" {{ old('gender', $user->gender) == 'Nam' ? 'checked' : '' }}
                                   class="form-radio h-6 w-6 text-indigo-600">
                            <span class="text-gray-700 text-lg">Nam</span>
                        </label>
                        <label class="flex items-center space-x-4 cursor-pointer">
                            <input type="radio" name="gender" value="Nữ" {{ old('gender', $user->gender) == 'Nữ' ? 'checked' : '' }}
                                   class="form-radio h-6 w-6 text-indigo-600">
                            <span class="text-gray-700 text-lg">Nữ</span>
                        </label>
                    </div>
                 
                </div>

                <div>
                    <label for="birthday" class="text-gray-700 font-semibold mb-3 block text-lg">Ngày sinh</label>
                    <input type="date" name="birthday" id="birthday" value="{{ old('birthday', $user->birthday) }}" 
                           class="w-full px-5 py-4 rounded-xl border-2 @error('birthday') border-red-500 @else border-gray-300 @enderror focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                 
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <button type="submit" 
                    class="bg-gray-600 text-white px-10 py-4 rounded-xl text-lg font-semibold hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-300">
                Lưu thay đổi
            </button>
        </div>
    </form>
</div>

<script>
// Hàm này dùng để xem trước ảnh avatar trước khi upload
function previewImage(input) {
    // Kiểm tra xem người dùng đã chọn file chưa và có file nào được chọn không
    if (input.files && input.files[0]) {
        // Tạo một đối tượng FileReader để đọc file
        var reader = new FileReader();
        
        // Khi file được load xong
        reader.onload = function(e) {
            // Cập nhật thuộc tính src của thẻ img có id là 'preview-avatar'
            // với dữ liệu ảnh dưới dạng base64
            document.getElementById('preview-avatar').setAttribute('src', e.target.result);
        }
        
        // Bắt đầu đọc file đã chọn và chuyển thành URL dạng base64
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection