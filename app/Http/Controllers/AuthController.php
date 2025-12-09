<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('client.auth.login');
    }
    // chức năng đăng nhập và phân quyền
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect('/admin')->with('success', 'Chào mừng Admin!');
            }
            // Check role = customer nếu đúng thì sang route serve/
            return redirect('/')->with('success', 'Đăng nhập thành công!');
        }

        return back()->with('error', 'Email hoặc mật khẩu không đúng!');
    }

    public function showRegister()
    {
        return view('client.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        return redirect('/login')->with('success', 'Đăng ký thành công!');
    }

    // ==============================
    // 🟦 QUÊN MẬT KHẨU
    // ==============================

    public function showForgotPasswordForm()
    {
        return view('client.auth.forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Email đặt lại mật khẩu đã được gửi!')
            : back()->withErrors(['email' => 'Email không tồn tại trong hệ thống']);
    }

    // ==============================
    // 🟩 HIỂN THỊ FORM ĐẶT MẬT KHẨU MỚI
    // ==============================

    public function showResetPasswordForm($token)
    {
        return view('client.auth.reset', ['token' => $token]);
    }

    // ==============================
    // 🟥 XỬ LÝ ĐẶT LẠI MẬT KHẨU
    // ==============================

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with('success', 'Đổi mật khẩu thành công!')
            : back()->withErrors(['email' => 'Token không hợp lệ hoặc đã hết hạn!']);
    }
}
