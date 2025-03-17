<?php

namespace App\Http\Controllers;

use App\Models\User;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginGoogleController extends Controller
{
    // Chuyển hướng người dùng đến Google OAuth
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    // Xử lý callback từ Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Thêm log để debug
            \Log::info('Google User:', [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'host' => request()->getHost(),
                'url' => request()->fullUrl()
            ]);

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'role_id' => 2, // Thêm role_id mặc định
                    'status' => 1   // Thêm status mặc định
                ]);
            }

            Auth::login($user);
            return redirect()->to('/');

        } catch (\Exception $e) {
            \Log::error('Google Login Error', [
            'message' => $e->getMessage(),
            'host' => request()->getHost(),
            'url' => request()->fullUrl()
        ]);
            return redirect()->route('login')
                ->with('error', 'Đăng nhập không thành công: ' . $e->getMessage());
        }
    }
}
