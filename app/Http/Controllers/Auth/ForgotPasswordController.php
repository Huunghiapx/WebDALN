<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Gửi email để đặt lại mật khẩu
        Password::sendResetLink($request->only('email'));

        return back()->with('status', 'Đường dẫn đặt lại mật khẩu đã được gửi đến email của bạn.');
    }
}
