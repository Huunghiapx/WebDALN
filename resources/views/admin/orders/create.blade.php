@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Tạo Đơn Hàng Mới</h1>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <!-- Chọn người dùng -->
        <div class="form-group">
            <label for="user_id">Khách Hàng:</label>
            <select name="user_id" class="form-control" required>
                <option value="">Chọn khách hàng</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Sản phẩm và số lượng -->
        <div class="form-group">
            <label for="items">Sản Phẩm:</label>
            <div id="order-items">
                <div class="row mb-3">
                    <div class="col">
                        <select name="items[0][product_id]" class="form-control" required onchange="updatePrice(this)">
                            <option value="">Chọn sản phẩm</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <input type="number" name="items[0][quantity]" class="form-control" placeholder="Số lượng" required min="1" oninput="updateSubtotal(this)">
                    </div>
                    <div class="col">
                        <input type="text" name="items[0][price]" class="form-control" placeholder="Giá" readonly>
                    </div>
                    <div class="col">
                        <input type="text" name="items[0][subtotal]" class="form-control" placeholder="Tổng tiền" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nút thêm sản phẩm -->
        <button type="button" class="btn btn-secondary" id="add-item">Thêm Sản Phẩm</button>

        <br><br>

        <!-- Ngày tạo đơn hàng -->
        <div class="form-group">
            <label for="order_date">Ngày Tạo Đơn:</label>
            <input type="date" name="order_date" class="form-control" required>
        </div>

        <!-- Hiển thị tổng tiền -->
        <div class="form-group">
            <label for="total_amount">Tổng Tiền:</label>
            <input type="text" name="total_amount" id="total_amount" class="form-control" readonly>
        </div>

        <!-- Nút tạo đơn hàng -->
        <button type="submit" class="btn btn-primary">Tạo Đơn Hàng</button>
    </form>
</div>

<!-- JavaScript để thêm sản phẩm và tính tổng tiền -->
<script>
    let itemIndex = 1;

    document.getElementById('add-item').addEventListener('click', function() {
        const orderItemsDiv = document.getElementById('order-items');
        const newItemRow = document.createElement('div');
        newItemRow.classList.add('row', 'mb-3');
        newItemRow.innerHTML = `
            <div class="col">
                <select name="items[${itemIndex}][product_id]" class="form-control" required onchange="updatePrice(this)">
                    <option value="">Chọn sản phẩm</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <input type="number" name="items[${itemIndex}][quantity]" class="form-control" placeholder="Số lượng" required min="1" oninput="updateSubtotal(this)">
            </div>
            <div class="col">
                <input type="text" name="items[${itemIndex}][price]" class="form-control" placeholder="Giá" readonly>
            </div>
            <div class="col">
                <input type="text" name="items[${itemIndex}][subtotal]" class="form-control" placeholder="Tổng tiền" readonly>
            </div>
        `;
        orderItemsDiv.appendChild(newItemRow);
        itemIndex++;
    });

    function updatePrice(select) {
        const row = select.closest('.row');
        const priceInput = row.querySelector('input[name$="[price]"]');
        const price = select.options[select.selectedIndex].getAttribute('data-price');
        priceInput.value = price ? price : '';
        updateSubtotal(row.querySelector('input[name$="[quantity]"]'));
    }

    function updateSubtotal(quantityInput) {
        const row = quantityInput.closest('.row');
        const priceInput = row.querySelector('input[name$="[price]"]');
        const subtotalInput = row.querySelector('input[name$="[subtotal]"]');
        const quantity = parseFloat(quantityInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;

        const subtotal = price * quantity;
        subtotalInput.value = subtotal.toFixed(2) + ' VND';
        calculateTotal();
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
