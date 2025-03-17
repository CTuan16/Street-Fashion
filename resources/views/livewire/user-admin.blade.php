<div> 
    <div class="flex flex-col">
        <div class="my-2 overflow-x-auto sm:mx-6 lg:mx-8">
          <div class="flex justify-between py-4">
            <h1 class="text-2xl font-semibold text-gray-700 ml-4">Tài khoản</h1>
            <a wire:click="openModal" class="btn inline-flex items-center px-4 py-2 mr-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
              Thêm Tài khoản
            </a>
          </div>
        </div>
        @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Thêm tài khoản</h2>
    
                <!-- Modal Form -->
                <form wire:submit.prevent="createUser">
                    <div class="mt-5">
                        <label for="name" class="block text-sm font-medium text-gray-700">Họ và Tên</label>
                        <input type="text" id="name" wire:model="name" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Vui lòng nhập họ và tên" />
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
    
                    <div class="mt-5">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" wire:model="email" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Vui lòng nhập email" />
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
    
                    <div class="mt-5">
                        <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                        <input type="password" id="password" wire:model="password" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Vui lòng nhập mật khẩu" />
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
    
                    <div class="mt-5">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                        <input type="text" id="phone" wire:model="phone" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Vui lòng nhập số điện thoại" />
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
    
                    <div class="mt-5">
                        <label for="birthday" class="block text-sm font-medium text-gray-700">Ngày sinh</label>
                        <input type="date" id="birthday" wire:model="birthday" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
                        @error('birthday') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
    
                    <div class="mt-5">
                        <label class="block text-sm font-medium text-gray-700">Giới tính</label>
                        <div class="mt-2 flex items-center space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="gender" value="male" wire:model="gender" class="border-gray-300 text-blue-600 focus:ring-blue-500" />
                                <span class="ml-2">Nam</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="gender" value="female" wire:model="gender" class="border-gray-300 text-blue-600 focus:ring-blue-500" />
                                <span class="ml-2">Nữ</span>
                            </label>
                        </div>
                        @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
    
                    <div class="mt-5">
                        <label for="role" class="block text-sm font-medium text-gray-700">Vai trò</label>
                        <select id="role" wire:model="role" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="admin">Admin</option>
                            <option value="customer">Customer</option>
                        </select>
                        @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
    
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Thêm tài khoản</button>
                        <button type="button" wire:click="closeModal" class="ml-2 bg-red-600 text-white px-4 py-2 rounded">Hủy</button>
                    </div>
                </form>
    
            </div>
        </div>
    @endif
    
    
        <!-- Thêm phần Search Bar vào giữa -->
        <div class="flex justify-center py-4 items-center">
          <!-- Search Bar -->
          <div class="relative w-1/2 max-w-lg">
              <input type="text" placeholder="Nhập từ khoá tìm kiếm" class="w-full py-2 px-4 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400">
              <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0 1 14 0z" />
                  </svg>
              </div>
          </div>
        </div>
        
                  @if (session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif
        
          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                
                <thead class="bg-gray-50">
                  <tr>
                    <th
                      scope="col"
                      class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Hình ảnh
                    </th>
                    <th
                      scope="col"
                      class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Tên Người Dùng
                    </th>
                    <th
                      scope="col"
                      class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Email
                    </th>
                    <th
                      scope="col"
                      class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Vai trò
                    </th>
                    <th
                      scope="col"
                      class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Trạng thái
                    </th>
                    <th
                      scope="col"
                      class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Số Điện Thoại
                    </th>
                    <th
                      scope="col"
                      class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Thao Tác
                    </th>
                  </tr>
                </thead>
                @foreach ($result_user as $user)
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900">
                      <!-- Hình ảnh tài khoản -->
                      <div class="flex justify-center">
                        <img src="{{$user['avatar']}}" alt="Hình ảnh người dùng" class="w-16 h-16 rounded-lg " >
                    </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">{{$user['name']}}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">{{$user['email']}}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">{{$user['role']}}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">{{$user['status']}}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">{{$user['phone']}}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                      <!-- Thao tác (Xóa, Sửa) -->
                      <a  wire:click="editUser({{$user->id}})" class="btn text-blue-600 hover:text-blue-900 mx-2">Sửa</a>
                      <form wire:submit.prevent="deleteUser({{ $user->id }})"  action="{{ route('qltaikhoan.destroy', $user->id) }}" method="POST" class="inline">
                         
                          <button type="submit" class="text-red-600 hover:text-red-900 mx-2" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">Xóa</button>
                      </form>
                      <tr >
                        <td></td>
                        <td></td>
                        <td></td>
                          <td colspan="1" class="px-6 py-4">
                           
                                      <div style="margin-left: 55px">
                                        @if ($showtogleEdit && $id === $user->id)    
                                        <select name="status" id="status" class="mt-1 block w-full" wire:model="status">
                                          @if (!old('status', $user->status))
                                              <option value="">{{ old('status', $user->status) ?: 'Chọn trạng thái' }}</option>
                                          @endif

                                          <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                                          <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        <button wire:click="updateUser({{ $user->id }})"  style="margin-left: 55px" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Lưu</button>
                                        @endif
                                      
                                     
                                      
                                        @error('gender')
                                            <span class="text-red-600">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>
                      
                            
                          </td>
                      </tr>
                      
                      <!-- Thêm các hàng dữ liệu khác nếu cần -->
                      </tbody>
                      @endforeach
                      
                      </table>
                      
                      </div>
                      </div>
                      </div>
                      </div>
                      
                      <!-- Modal -->
                    
                      
                      
</div>



