<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('admin.orders.index', compact('orders')); // Đảm bảo rằng view nằm trong thư mục admin
    }

    public function create()
    {
        $users = User::all(); // Lấy danh sách người dùng
        $products = Product::all(); // Lấy danh sách sản phẩm
    
        return view('admin.orders.create', compact('users', 'products')); // Đảm bảo rằng view nằm trong thư mục admin
    }

    public function store(Request $request)
    {   
        $request->validate([
            'user_id' => 'required|exists:users,id', // Kiểm tra tồn tại trong bảng users
            'items' => 'required|array', // Kiểm tra rằng có ít nhất một mục hàng
            'order_date' => 'required|date', // Kiểm tra ngày đặt hàng
            'total_amount' => 'required|string', // Xác nhận rằng total_amount tồn tại
        ]);
    
        // Loại bỏ "VND" và chuyển đổi thành số thực
        $totalAmount = floatval(str_replace(' VND', '', $request->total_amount));
    
        // Tạo đơn hàng mới
        $order = Order::create([
            'user_id' => $request->user_id,
            'total_amount' => $totalAmount, // Lưu lại giá trị số thực của total_amount
            'order_date' => $request->order_date,
        ]);
        
        // Lưu từng mục hàng vào bảng order_items
        foreach ($request->items as $item) {
            // Kiểm tra xem giá và số lượng có phải là số hay không
            $price = floatval($item['price']);
            $quantity = intval($item['quantity']);
        
            if (!is_numeric($price) || !is_numeric($quantity)) {
                // Xử lý trường hợp không phải số
                return redirect()->back()->withErrors('Giá hoặc số lượng không hợp lệ.')->withInput();
            }
        
            $subtotal = $price * $quantity; // Tính subtotal cho mỗi sản phẩm
        
            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $quantity,
                'price' => $price, // Giá mỗi sản phẩm
                'subtotal' => $subtotal, // Lưu subtotal
            ]);
        }
        
        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được tạo thành công.');
    }
    
    public function show($id)
    {
        $order = Order::findOrFail($id); // Tìm đơn hàng theo ID
        return view('admin.orders.show', compact('order')); // Đảm bảo rằng view nằm trong thư mục admin
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id); // Tìm đơn hàng theo ID
        $users = User::all(); // Lấy danh sách người dùng
        $products = Product::all(); // Lấy danh sách sản phẩm

        return view('admin.orders.edit', compact('order', 'users', 'products')); // Đảm bảo rằng view nằm trong thư mục admin
    }

    public function update(Request $request, $id)
    {
        // Xác thực yêu cầu
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'order_date' => 'required|date',
            'status' => 'required|string',
        ]);

        // Tìm đơn hàng theo ID
        $order = Order::findOrFail($id);

        // Cập nhật thông tin đơn hàng
        $order->update([
            'user_id' => $request->user_id,
            'order_date' => $request->order_date,
            'status' => $request->status,
        ]);

        $totalAmount = 0; // Biến để lưu tổng tiền

        // Cập nhật các mục hàng
        foreach ($request->items as $item) {
            if (!isset($item['id'])) {
                return redirect()->back()->withErrors('Mỗi mục hàng cần có ID.')->withInput();
            }

            $orderItem = $order->items()->where('id', $item['id'])->first();
            
            if ($orderItem) {
                $price = floatval($item['price']);
                $quantity = intval($item['quantity']);
                $subtotal = $price * $quantity; // Tính subtotal cho mỗi sản phẩm

                // Cập nhật thông tin mục hàng
                $orderItem->update([
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                $totalAmount += $subtotal; // Cộng dồn subtotal vào tổng tiền
            }
        }

        // Cập nhật tổng tiền
        $order->update(['total_amount' => $totalAmount]);

        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được cập nhật thành công.');
    }

    public function destroy($id)
    {   
        $order = Order::findOrFail($id); // Tìm đơn hàng theo ID
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được xóa thành công.');
    }
}
