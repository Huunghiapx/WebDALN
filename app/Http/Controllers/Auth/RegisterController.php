<?php 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    

    public function register(Request $request)
    {
         
        $request->validate([
            
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20', // Thêm trường phone
            'address' => 'required|string|max:255', // Thêm trường address
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone, // Lưu phone
            'address' => $request->address, // Lưu address
        ]);

        return redirect('/login')->with('success', 'Đăng ký thành công. Bạn có thể đăng nhập.');
    }
}
