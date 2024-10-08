<?php

// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; 
use App\Models\User; // Hoặc Customer nếu bạn đang sử dụng model này
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy danh sách tất cả người dùng
        $users = User::all(); 
        return view('home', compact('users')); // Truyền dữ liệu đến view
    }
}

