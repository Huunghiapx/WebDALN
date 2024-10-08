<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        // Lấy thông tin người dùng hiện tại
        $user = Auth::user();

        // Trả về view hồ sơ với dữ liệu người dùng
        return view('profile.show', compact('user'));
    }
}

