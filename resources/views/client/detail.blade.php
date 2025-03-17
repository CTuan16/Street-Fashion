@extends('layout.layoutClient')
@section('title')
sp chi tiết
@endsection
@section('body')


<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" >
    <div class="grid grid-cols-12 space-x-10">
        <div class="md:col-span-3 col-span-12 flex justify-center items-center">
            <img src="{{ asset($product->primary_image) }}" alt="Hình ảnh 1"/>
        </div>
        <div class="min-h-full flex flex-col justify-center sm:px-6 lg:px-8 md:col-span-6 col-span-12">
            <form method="POST" action="{{ route('cart.add', $product->id) }}">
                @csrf
            <div class=" w-100 relative z-10">
                <div class="py-8 px-4 sm:rounded-lg">
                    
                    <h2 class="text-3xl font-bold">{{ $product->name }}</h2>
                    @foreach ($product->product_meta as $product_meta)
                        @if($product_meta->product_sale == 'sale')
                            <h3 class="mt-5 text-2xl font-bold">
                                <span class="line-through text-gray-500">{{ number_format($product_meta->price) }} VNĐ</span>
                                <span class="text-red-600">{{ number_format($product_meta->price_sale) }} VNĐ</span>
                            </h3>
                        @else
                            <h3 class="mt-5 text-2xl font-bold">{{ number_format($product_meta->price) }} VNĐ</h3>
                        @endif
                    @endforeach
                    
                    <p class="mt-5"><strong>Thông tin sản phẩm:</strong> {{$product->description}}</p>
                    <li class="mt-5"><strong>Chất liệu:</strong> Thun</li>
                    <li><strong>Kỹ thuật:</strong> In</li>
                    <hr class="mt-3" style="border: 1px solid #EAD99E">
        
                    <div>
                       
                        <div class="flex items-center gap-3 mt-4">
                            <p class="text-base"><strong>Color:</strong></p>
                            <select name="color" class="text-sm px-3 py-1.5 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 bg-white">
                                <option value="">Chọn màu</option>
                                @foreach ($product->productcolor as $color)
                                    <option value="{{ $color->color->name_color }}" class="hover:bg-gray-100">{{ $color->color->name_color }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-3 mt-4">
                            <p class="text-base"><strong>Size:</strong></p>
                            <div class="inline-flex gap-2">
                                @foreach ($product->productsize as $size)
                                    <label class="size-option">
                                        <input type="radio" name="size" value="{{ $size->size->name_size }}" class="hidden">
                                        <span class="px-3 py-1.5 border-2  rounded-md cursor-pointer 0 hover:bg-indigo-50">
                                            {{ $size->size->name_size }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                     
                    </div>
                    @if(session('error'))
                    <div class="alert alert-danger text-red-500 mt-2">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="flex flex-col gap-5">
                        <button type="button" id="sizeGuideBtn" class="text-left mt-5  border-b-2 border-black w-48 hover:text-gray-600">
                            Hướng dẫn chọn size
                        </button>
                    </div>

                    <!-- Size Guide Modal -->
                    <div id="sizeGuideModal" class="size-guide-modal">
                        <div class="modal-content">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-bold">Hướng dẫn chọn size</h3>
                                <button type="button" id="closeModal" class="text-gray-500 hover:text-gray-700">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-300">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b">Chiều cao</th>
                                            <th class="py-2 px-4 border-b">Cân nặng</th>
                                            <th class="py-2 px-4 border-b">Size đề xuất</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr>
                                            <td class="py-2 px-4 border-b">1m50 - 1m55</td>
                                            <td class="py-2 px-4 border-b">40kg - 45kg</td>
                                            <td class="py-2 px-4 border-b">S</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-4 border-b">1m56 - 1m65</td>
                                            <td class="py-2 px-4 border-b">46kg - 55kg</td>
                                            <td class="py-2 px-4 border-b">M</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-4 border-b">1m66 - 1m72</td>
                                            <td class="py-2 px-4 border-b">56kg - 65kg</td>
                                            <td class="py-2 px-4 border-b">L</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-4 border-b">1m73 - 1m80</td>
                                            <td class="py-2 px-4 border-b">66kg - 75kg</td>
                                            <td class="py-2 px-4 border-b">XL</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-sm text-gray-600">
                                <p>* Lưu ý: Bảng size chỉ mang tính chất tham khảo. Kích thước thực tế có thể thay đổi 1-2cm.</p>
                                <p>* Nếu bạn đang cân nhắc giữa hai size, nên chọn size lớn hơn để thoải mái hơn.</p>
                            </div>
                        </div>
                    </div>
        
                    <!-- Nút Thêm vào Giỏ hàng -->
                    <div class="mt-8 flex ">
                        @if(auth()->check())
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Thêm vào giỏ hàng
                            </button>
                        @else
                            <button onclick="alert('Vui lòng đăng nhập để mua hàng!')" type="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Thêm vào giỏ hàng
                            </button>
                        @endif
                    </div>
                </form>
                </div>
            </div>
        
        </div>
        
        <div class="md:col-span-3 col-span-12 flex justify-center items-center">
            <img src="{{ asset($product->second_image) }}" alt="Hình ảnh 2" />
        </div>
        <div class="col-span-12 justify-left items-center">
            <button class="col-span-12 flex text-xl items-center " id="toggle-btn">Chính sách đổi trả<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9" />
            </svg>
            </button>
            <p id="product-details" style="display: none" class="col-span-12">
                Street Fashion nhận đổi hàng trong vòng 30 ngày, kể từ ngày khách hàng nhận sản phẩm áp dụng với mọi sản phẩm áo quần, phụ kiện mua tại online. <br>
                
                        <strong>1. ĐIỀU KIỆN ĐỔI HÀNG:</strong> <br>
                
                Áp dụng 01 lần đổi/ 01 đơn hàng. Vui lòng thanh toán chi phí chênh lệch nếu sản phẩm đổi có giá trị cao hơn sản phẩm được đổi và không hoàn trả nếu sản phẩm đổi có giá trị thấp hơn.
                
                Sản phẩm phải còn bill, còn nguyên tag, ở trong tình trạng chưa qua sử dụng, không có mùi hương lạ. <br>
                <strong>2. ĐIỀU KIỆN ĐỔI HÀNG:</strong><br>
                <strong> Lỗi khách quan:</strong> Khách hàng không còn ưa thích hoặc sản phẩm không vừa vặn <br>

                <strong>Lỗi giao hàng:</strong> Sản phẩm bị ảnh hưởng trong quá trình vận chuyển hoặc giao sai mẫu hoặc size mà khách hàng đã đặt <br>

                <strong>Lỗi sản xuất:</strong> Những lỗi phát sinh từ phía Double Bad <br>
                <strong>3.  HƯỚNG DẪN ĐỔI TRẢ:</strong><br>
                Đổi trả trực tiếp tại địa chỉ văn phòng của Street Fashion: 148 Nguyễn Hữu Dật (kho số 3), Phường Tây Thạnh, Quận Tân Phú,Thành phố Hồ Chí Minh (bạn vui lòng liên hệ qua Facebook / Direct Instagram trước để nhân viên check và hướng dẫn cách gửi hàng nhé). <br>
                
                
                Sau khi nhận được hàng, Bad sẽ liên hệ với bạn và tiến hành kiểm tra sản phẩm theo quy định đổi sản phẩm. <br>
                <strong> 4.  NHỮNG TRƯỜNG HỢP SẢN PHẨM KHÔNG ÁP DỤNG ĐỔI TRẢ:</strong><br>
                - Sản phẩm hư hại bởi những tác nhân bên ngoài, không xác định được lỗi do phía sản xuất <br>
                - Sản phẩm không còn tem, mác, không xác định được nguồn gốc sản phẩm <br>
                - Sản phẩm đã quá thời hạn đổi trả <br>
                - Quy trình giặt, bảo quản sản phẩm không đúng quy cách dẫn đến sản phẩm bị hư hại <br>
                - Phụ kiện: Vớ, quần lót <br>
                - Quà tặng đặc biệt, số lượng giới hạn <br>
            </p>
        </div>
    </div>
        
       
    
    {{-- Bình luận --}}
 <div class="mt-12 max-w-7xl mx-auto bg-white rounded-lg shadow-md p-8">
   

   
        <div class="bg-gray-50 rounded-lg shadow-md p-6 max-w-2xl mx-auto">
            <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">
                Tổng quan đánh giá
            </h3>
            
            <div class="text-center">
                <span class="text-4xl font-bold text-gray-800">
                    {{ number_format($averageRating, 1) }}
                </span>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="flex">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-6 h-6 {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}" 
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                </div>
                
                <p class="text-gray-600 font-medium">
                    {{ $totalRatings }} đánh giá
                </p>
            </div>
        </div>

      
        @if(auth()->check())
        <div class="mt-12">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Viết đánh giá</h3>
            <form action="{{ route('rating.store', $product->id) }}" method="POST" class="space-y-4">
                @csrf
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-gray-700">Đánh giá:</span>
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden peer">
                            <label for="star{{ $i }}" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400" 
                                onmouseover="highlightStars({{ $i }})" 
                                onmouseout="resetStars()"
                                onclick="selectStar({{ $i }})">
                                ★
                            </label>
                        @endfor
                    </div>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Bình luận của bạn</label>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="4" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này..."
                        required
                    ></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Gửi đánh giá
                    </button>
                </div>
            </form>

           
        </div>
    @else
        <div class="mt-12 text-center">
            <p class="text-gray-600">Vui lòng <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800">đăng nhập</a> để viết đánh giá</p>
        </div>
    @endif


    <div class="mt-12">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Đánh giá từ khách hàng</h3>
        <ul id="rating" class="space-y-6">
            @if(isset($ratings) && count($ratings) > 0)
                @foreach($ratings->sortByDesc('created_at') as $rating)
                    <li class="bg-gray-50 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                @if($rating->user->avatar)
                                    @if($rating->user->avatar && $rating->user->avatar != 'no_avt.jpg')
                                        <img src="{{ asset('img/avt/' . $rating->user->avatar) }}" alt="Avatar" class="w-10 h-10 rounded-full">
                                    @else
                                        <img src="{{ asset('img/avt/no_avt.jpg') }}" alt="Avatar" class="w-10 h-10 rounded-full">
                                    @endif
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-gray-600 text-lg font-semibold">{{ substr($rating->user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="font-semibold text-gray-800">{{ $rating->user->name }}</span>
                                    <span class="text-gray-500 text-sm">•</span>
                                    <span class="text-gray-500 text-sm">{{ $rating->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="flex items-center mb-2 ">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $rating->rating)
                                            <span class="text-yellow-400 text-xl">★</span>
                                        @else
                                            <span class="text-gray-300 text-xl">★</span>
                                        @endif
                                    @endfor
                                </div>
                                <p class="text-gray-700 leading-relaxed ">{{ $rating->content }}</p>
                                

                            </div>
                            <!-- Xóa bình luận ch xoa bang js -->
                            @if(auth()->check() && auth()->id() == $rating->user_id)
                                    <form action="{{ route('delete.rating', $rating->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </li>
                @endforeach
            @else
                <li class="text-center text-gray-500 py-8">Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá sản phẩm này!</li>
            @endif
        </ul>
    </div>
    </div> 

    
 
        
        
    {{-- Sản phẩm tương tự --}}
   
   
        <!-- Add more product cards similarly -->
    

    
    
    
</div>
<script src="{{ asset('js/detail.js') }}"></script>
<script src="{{ asset('js/comment.js') }}"></script>

@endsection