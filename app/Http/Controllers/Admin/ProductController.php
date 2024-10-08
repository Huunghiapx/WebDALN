<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Product;
use App\Models\Category; // Thêm Model Category
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Thêm để sử dụng Storage

class ProductController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index()
    {
        $products = Product::all(); // Lấy tất cả sản phẩm
        return view('admin.products.index', compact('products')); // Trả về view với danh sách sản phẩm
    }

    // Hiển thị form thêm sản phẩm
    public function create()
    {
        $categories = Category::all(); // Lấy tất cả categories
        return view('admin.products.create', compact('categories')); // Trả về view và truyền danh sách categories
    }

    // Lưu thông tin sản phẩm mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id', // Thêm category_id
        ]);

        // Lưu hình ảnh và nhận đường dẫn
        $path = $request->file('image')->store('products', 'public'); 

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'image' => $path, // Lưu đường dẫn hình ảnh vào cơ sở dữ liệu
            'category_id' => $request->category_id, // Lưu category_id vào cơ sở dữ liệu
        ]);

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được thêm thành công.'); // Chuyển hướng về danh sách sản phẩm
    }

    // Hiển thị chi tiết sản phẩm
    public function show($id)
    {
        $product = Product::findOrFail($id); // Tìm sản phẩm theo ID
        return view('admin.products.show', compact('product')); // Trả về view chi tiết sản phẩm
    }

    // Hiển thị form chỉnh sửa sản phẩm
    public function edit($id)
    {
        $product = Product::findOrFail($id); // Tìm sản phẩm theo ID
        $categories = Category::all(); // Lấy tất cả categories
        return view('admin.products.edit', compact('product', 'categories')); // Trả về view với sản phẩm và danh sách categories
    }

    // Cập nhật thông tin sản phẩm
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id', // Thêm category_id
        ]);

        $product = Product::findOrFail($id); // Tìm sản phẩm theo ID

        // Kiểm tra xem có hình ảnh mới không
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Lưu hình ảnh mới
            $path = $request->file('image')->store('products', 'public'); 
            $product->image = $path; // Cập nhật đường dẫn hình ảnh
        }

        $product->update($request->only(['name', 'price', 'quantity', 'description', 'category_id'])); // Cập nhật các trường còn lại

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được cập nhật thành công.'); // Chuyển hướng về danh sách sản phẩm
    }

    // Xóa sản phẩm
    public function destroy($id)
    {
        $product = Product::findOrFail($id); // Tìm sản phẩm theo ID

        // Xóa ảnh nếu có
        if ($product->image) {
            Storage::disk('public')->delete($product->image); // Xóa ảnh khỏi thư mục
        }

        $product->delete(); // Xóa sản phẩm
        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được xóa thành công.'); // Chuyển hướng về danh sách sản phẩm
    }
}
