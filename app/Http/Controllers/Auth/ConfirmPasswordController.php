<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ConfirmPasswordController extends Controller
{
    /**
     * Hiển thị form xác nhận mật khẩu.
     *
     * @return \Illuminate\View\View
     */
    public function showConfirmForm()
    {
        return view('auth.passwords.confirm');
    }

    /**
     * Xác thực mật khẩu người dùng.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function confirm(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => [__('Mật khẩu không đúng.')],
            ]);
        }

        // Nếu xác thực thành công, xác nhận lại mật khẩu.
        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended();
    }
}
