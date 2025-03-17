<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function sendOtp(Request $request)
    {
        try {     
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        
        $otp = rand(1000, 9999); // Tạo mã OTP 6 chữ số
        
        // Lưu OTP vào bảng `customers`
        $customer = User::where('email', $request->email)->first();
        $customer->otp_code = $otp;
        $customer->otp_expires_at = now()->addMinutes(10); // OTP hết hạn sau 10 phút
        $customer->save();
        
        // Gửi OTP qua email
        session(['otp_email' => $request->email]);
            Mail::raw("Mã OTP của bạn là: $otp", function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Quên mật khẩu - Mã OTP');
            });
            return redirect()->route('verifyOtpForm')->with('success', 'Mã OTP đã được gửi thành công!');

        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể gửi email: ' . $e->getMessage()], 500);
        }
    }

    public function showVerifyOtpForm(Request $request)
{
    // Kiểm tra xem email có được lưu trong session chưa
    if (!$request->session()->has('otp_email')) {
        return redirect()->route('forgotView')->withErrors(['email' => 'Phiên làm việc đã hết hạn.']);
    }

    // Trả về view nhập OTP
    return view('client.form.verify_otp');
}


public function showResetPasswordForm()
{
    return view('client.form.reset_password');
}

public function resetPassword(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'password' => 'required|min:8|confirmed', // Xác nhận mật khẩu
    ]);

    // Lấy email từ session
    $email = session('otp_email');

    // Tìm người dùng và cập nhật mật khẩu
    $customer = User::where('email', $email)->first();

    if ($customer) {
        $customer->password = Hash::make($request->password); // Mã hóa mật khẩu mới
        $customer->otp_code = null; // Xóa mã OTP
        $customer->otp_expires_at = null; // Xóa thời gian hết hạn OTP
        $customer->save();

        return redirect()->route('login')->with('success', 'Mật khẩu đã được thay đổi thành công.');
    } else {
        return redirect()->back()->with('error', 'Không tìm thấy người dùng.');
    }
}
}