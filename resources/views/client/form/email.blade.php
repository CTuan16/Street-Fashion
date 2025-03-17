@extends('layout.layoutClient')
@section('title')
    Email
@endsection
@section('body')
<div class="mx-10 my-10" style="color: aliceblue; border: 1px solid rgb(223, 216, 216); border-radius: 10px; padding: 20px; display: flex; flex-direction: column; max-width: 550px; margin: auto; position: relative; overflow: hidden;">
    <!-- Hình nền bằng hình ảnh -->
    <img src="/img/Form/dn.png" alt="background" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1; filter: brightness(50%);">
    
    <!-- Nội dung chính -->
    <h2 class="h-20 text-2xl text-center font-bold" style="border-bottom: 1px solid; width: 100%; padding-bottom: 10px; margin-bottom: 15px">Quên Mật Khẩu</h2>
    
    <h3 style="margin-bottom: 10px; ">Xin chào, Hoàng Thiên!</h3>
    
    <p style="margin-bottom: 15px; ">Có vẻ như bạn đã quên mật khẩu của mình. Đừng lo lắng, chỉ cần nhấp vào liên kết bên dưới để nhận một mật khẩu mới:</p>
    
    <button style="padding: 10px 20px; background-color: #0e1fdd; color: white; border: none; border-radius: 5px; cursor: pointer; margin-bottom: 15px;">Đặt lại mật khẩu</button>

    <p style="">Liên kết sẽ hết hạn sau 24 giờ, vì vậy hãy nhấp vào liên kết nhanh hơn! Nếu bạn chưa yêu cầu email này, vui lòng bỏ qua nó.</p>
    
    <p class="mt-5" style="">Trân trọng,</p>
    <p style="border-bottom: 1px solid; width: 100%; padding-bottom: 10px; margin-bottom: 15px; ">Đội ngũ hỗ trợ</p>
    
    <p class="text-xs text-center" style="">Đối với các yêu cầu hỗ trợ, vui lòng liên hệ với chúng tôi tại <strong>streetfashion@gmail.com</strong></p>
    <p class="text-xs text-center" style="">hoặc Hotline hỗ trợ: <strong>0376206645</strong></p>
</div>



        
@endsection
