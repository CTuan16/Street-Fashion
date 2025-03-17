<?php

namespace App\Http\Controllers;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerifyOtpController extends Controller
{
    public function verifyOtpForm(Request $request)
{
    $request->validate([
        'otp_code' => 'required|numeric',
    ]);

    // Lấy email từ session
    $email = session('otp_email');

    if (!$email) {
        return redirect()->back()->with('error', 'Không tìm thấy email trong session, vui lòng thử lại.');
    }

    // Tìm người dùng theo email
    $customer = User::where('email', $email)->first();

    if (!$customer) {
        return redirect()->back()->with('error', 'Người dùng không tồn tại.');
    }
    // Kiểm tra mã OTP và thời gian hết hạn
    if ($customer->otp_code === $request->otp_code && Carbon::parse($customer->otp_expires_at)->isFuture()) {
        // OTP hợp lệ
        return redirect()->route('resetPasswordForm')->with('success', 'Mã OTP hợp lệ. Vui lòng tiếp tục.');
    } else {
        return redirect()->back()->with('error', 'Mã OTP không hợp lệ hoặc đã hết hạn.');
    }
}


}