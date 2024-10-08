<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Đảm bảo bạn đã import mô hình User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Thêm vào để sử dụng Storage

class UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index()
    {
        $users = User::all(); // Lấy tất cả người dùng
        return view('admin.users.index', compact('users')); // Trả về view với danh sách người dùng
    }

    // Hiển thị form thêm người dùng
    public function create()
    {
        return view('admin.users.create'); // Trả về view để tạo người dùng
    }

    // Lưu thông tin người dùng mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:8', // Thêm quy tắc xác thực cho mật khẩu
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Quy tắc xác thực cho ảnh
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); // Lưu ảnh và lấy đường dẫn
        }

        User::create(array_merge($request->all(), [
            'role' => $request->input('role', 'customer'), // Mặc định là customer
            'password' => bcrypt($request->password), // Mã hóa mật khẩu
            'image' => $imagePath, // Lưu đường dẫn ảnh vào cơ sở dữ liệu
        ])); 

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được thêm thành công.'); // Chuyển hướng đến danh sách người dùng
    }

    // Hiển thị form chỉnh sửa người dùng
    public function edit($id)
    {
        $user = User::findOrFail($id); // Tìm người dùng theo ID
        return view('admin.users.edit', compact('user')); // Trả về view để chỉnh sửa người dùng
    }

    // Cập nhật thông tin người dùng
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone_number' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Quy tắc xác thực cho ảnh
        ]);

        $user = User::findOrFail($id); // Tìm người dùng theo ID

        $data = $request->except('password', 'image'); // Lấy dữ liệu ngoại trừ password và image
        $data['role'] = $request->input('role', 'customer'); // Cập nhật vai trò, mặc định là customer

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            // Lưu ảnh mới
            $data['image'] = $request->file('image')->store('images', 'public'); 
        }

        // Cập nhật thông tin người dùng
        $user->update($data);

        // Nếu có mật khẩu mới, cập nhật mật khẩu
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password); // Mã hóa mật khẩu mới
            $user->save(); // Lưu thông tin
        }

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được cập nhật thành công.'); // Chuyển hướng đến danh sách người dùng
    }

    // Xóa người dùng
    public function destroy($id)
    {
        $user = User::findOrFail($id); // Tìm người dùng theo ID

        // Xóa ảnh nếu có
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete(); // Xóa người dùng
        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa thành công.'); // Chuyển hướng đến danh sách người dùng
    }

    public function show($id)
    {
        $user = User::findOrFail($id); // Tìm người dùng theo ID
        return view('admin.users.show', compact('user')); // Trả về view với dữ liệu người dùng
    }
}
