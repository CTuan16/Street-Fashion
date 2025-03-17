<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class myacController extends Controller
{
    public function myAC()
    {
        $user = User::find(Auth::user()->id);
        if (!$user->avatar) {
            $user->avatar = 'no_avt.jpg';
            $user->save();
        }
        return view('client.myac', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // Validate input data
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:11',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|in:Nam,Nữ',
            'avatar' => 'nullable|image|mimes:jpeg,png|max:1024'
        ], [
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được sử dụng',
            'phone.regex' => 'Số điện thoại không hợp lệ', 
            'phone.min' => 'Số điện thoại phải có ít nhất 10 số',
            'phone.max' => 'Số điện thoại không được quá 11 số'
        ]);

        $user = User::find(Auth::user()->id);

        // Update user information
        $user->name = $request->input('name');
        $user->email = $request->input('email'); 
        $user->phone = $request->input('phone');
        $user->birthday = $request->input('birthday');
        $user->gender = $request->input('gender');

        // Update avatar if provided
        if ($request->hasFile('avatar')) {
            // Delete old avatar if not default
            if ($user->avatar && $user->avatar != 'no_avt.jpg') {
                $oldAvatarPath = public_path('img/avt/' . $user->avatar);
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }

            // Save new avatar
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('img/avt'), $filename);
            $user->avatar = $filename;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
