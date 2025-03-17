<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\notifyRegister;
use Illuminate\Support\Facades\Mail;

class formController extends Controller
{
    public function Checkdn(Request $request)
    {
        // Xác thực dữ liệu nhập vào
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email không được để trống',
            'password.required' => ['Mật khẩu không được để trống'],
        ]);

        // Thử đăng nhập
        if (Auth::attempt($credentials)) {

            // Kiểm tra vai trò của người dùng
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('dashboard'); // chuyển hướng đến trang dashboard
            }

            // Chuyển hướng người dùng không phải admin về trang mặc định
            return redirect()->intended('/');
        }

        // Đăng nhập thất bại
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ]);
    }
    public function Logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
    public function Checkdk(Request $request)
    {
        // Kiểm tra dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'required|digits:10',
            'date' => 'required|date',
            'gender' => 'required',
        ], [
            'name.required' => 'Họ và tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.digits' => 'Số điện thoại phải là 10 chữ số.',
            'date.required' => 'Ngày sinh là bắt buộc.',
            'gender.required' => 'Giới tính là bắt buộc.',
        ]);
        $result = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'birthday' => $request->date,
            'gender' => $request->gender,
            'avatar' => '/img/avt/no_avt.jpg',
            'role_id' => 2 
        ]);
        Mail::to($request->email)->send(new notifyRegister($request->name));
        // Nếu kiểm tra hợp lệ, tiếp tục xử lý (ví dụ lưu dữ liệu vào database)
        return redirect()->intended('login');
    }
    public function Checkfg(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|regex:/^[\w\.]+@[\w\.]+\.[a-z]{2,}$|regex:/^[0-9]+$/',
        ], [
            'email.required' => 'Trường email hoặc số điện thoại là bắt buộc.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.regex' => 'Vui lòng nhập email hoặc số điện thoại hợp lệ.',
        ]);

        // Sau khi kiểm tra, bạn có thể xử lý dữ liệu
        return back()->with('success', 'Dữ liệu đã được gửi thành công!');
    }
    public function Checkcf(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ], [
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'confirm_password.required' => 'Xác nhận mật khẩu là bắt buộc.',
            'confirm_password.same' => 'Mật khẩu xác nhận không khớp.',
        ]);

        // Sau khi xác thực thành công, bạn có thể xử lý dữ liệu
        return back()->with('success', 'Mật khẩu đã được xác nhận thành công!');
    }
}