<?php 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $user = Auth::user(); // Lấy thông tin người dùng hiện tại

            // Kiểm tra vai trò của người dùng
            if ($user->role === 'admin') {
                return redirect()->intended('/admin'); // Điều hướng đến trang admin nếu là admin
            } else {
                return redirect()->intended('/index'); // Điều hướng đến trang index nếu không phải admin
            }
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Bạn đã đăng xuất thành công.');
    }
}
