@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Sửa Đơn Hàng</h1>

    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Chọn người dùng -->
        <div class="form-group">
            <label for="user_id">Khách Hàng:</label>
            <select name="user_id" class="form-control" required>
                <option value="">Chọn khách hàng</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $order->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Trạng thái đơn hàng -->
        <div class="form-group">
            <label for="status">Trạng Thái:</label>
            <select name="status" class="form-control" required>
                <option value="PENDING" {{ $order->status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                <option value="COMPLETED" {{ $order->status == 'COMPLETED' ? 'selected' : '' }}>COMPLETED</option>
                <option value="CANCELLED" {{ $order->status == 'CANCELLED' ? 'selected' : '' }}>CANCELLED</option>
            </select>
        </div>

        <!-- Sản phẩm và số lượng -->
        <div class="form-group">
            <label for="items">Sản Phẩm:</label>
            <div id="order-items">
                @foreach($order->items as $index => $item)
                    <div class="row mb-3">
                        <div class="col">
                            <select name="items[{{ $index }}][product_id]" class="form-control" required onchange="updatePrice(this)">
                                <option value="">Chọn sản phẩm</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" {{ $product->id == $item->product_id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <input type="number" name="items[{{ $index }}][quantity]" class="form-control" placeholder="Số lượng" value="{{ $item->quantity }}" required min="1" oninput="calculateSubtotal(this)">
                        </div>
                        <div class="col">
                            <input type="text" name="items[{{ $index }}][price]" class="form-control" placeholder="Giá" value="{{ number_format($item->price, 0, ',', '.') }}" readonly>
                        </div>
                        <div class="col">
                            <input type="text" name="items[{{ $index }}][subtotal]" class="form-control" placeholder="Subtotal" value="{{ number_format($item->subtotal, 0, ',', '.') }} VND" readonly>
                        </div>
                        <!-- Thêm input để lưu ID của mục hàng -->
                        <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Ngày tạo đơn hàng -->
        <div class="form-group">
            <label for="order_date">Ngày Tạo Đơn:</label>
            <input type="date" name="order_date" class="form-control" value="{{ $order->order_date }}" required>
        </div>

        <!-- Hiển thị tổng tiền -->
        <div class="form-group">
            <label for="total_amount">Tổng Tiền:</label>
            <input type="text" name="total_amount" id="total_amount" class="form-control" value="{{ number_format($order->total_amount, 0, ',', '.') }} VND" readonly>
        </div>

        <!-- Nút cập nhật đơn hàng -->
        <button type="submit" class="btn btn-primary">Cập Nhật Đơn Hàng</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Trở về danh sách đơn hàng</a>

    </form>
</div>

<script>
    function updatePrice(select) {
        const priceInput = select.closest('.row').querySelector('input[name$="[price]"]');
        const quantityInput = select.closest('.row').querySelector('input[name$="[quantity]"]');
        const subtotalInput = select.closest('.row').querySelector('input[name$="[subtotal]"]');

        const price = select.options[select.selectedIndex].getAttribute('data-price');
        priceInput.value = price ? price + ' VND' : '';
        
        // Tính subtotal
        calculateSubtotal(quantityInput);
        calculateTotal();
    }

    function calculateSubtotal(quantityInput) {
        const row = quantityInput.closest('.row');
        const priceInput = row.querySelector('input[name$="[price]"]');
        const subtotalInput = row.querySelector('input[name$="[subtotal]"]');

        const quantity = parseFloat(quantityInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;

        const subtotal = quantity * price;
        subtotalInput.value = subtotal.toFixed(2) + ' VND';

        calculateTotal(); // Cập nhật tổng tiền
    }

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('#order-items .row').forEach(function(row) {
            const subtotalInput = row.querySelector('input[name$="[subtotal]"]');
            const subtotal = parseFloat(subtotalInput.value) || 0;

            total += subtotal;
        });

        document.getElementById('total_amount').value = total.toFixed(2) + ' VND';
    }
</script>
@endsection
