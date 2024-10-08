<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category; 


class CategoryController extends Controller
{
    // Hiển thị danh sách loại sản phẩm
    public function index()
    {
        $categories = Category::all(); // Lấy tất cả loại sản phẩm
        return view('admin.categories.index', compact('categories'));
    }

    // Hiển thị form thêm mới loại sản phẩm
    public function create()
    {
        return view('admin.categories.create');
    }

    // Lưu loại sản phẩm mới
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Tạo loại sản phẩm mới
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Thêm loại sản phẩm thành công');
    }

    // Hiển thị chi tiết loại sản phẩm
    public function show($id)
    {
        $category = Category::with('products')->findOrFail($id); // Lấy loại sản phẩm theo ID và sản phẩm liên quan
        return view('admin.categories.show', compact('category'));
    }

    // Hiển thị form chỉnh sửa loại sản phẩm
    public function edit($id)
    {
        $category = Category::findOrFail($id); // Lấy loại sản phẩm theo ID
        return view('admin.categories.edit', compact('category'));
    }

    // Cập nhật loại sản phẩm
    public function update(Request $request, $id)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Lấy loại sản phẩm cần cập nhật
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Cập nhật loại sản phẩm thành công');
    }

    // Xóa loại sản phẩm
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Kiểm tra xem loại sản phẩm có sản phẩm nào liên quan không
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Không thể xóa loại sản phẩm này vì vẫn còn sản phẩm liên quan.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Xóa loại sản phẩm thành công');
    }
}
