@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Chi Tiết Đơn Hàng #{{ $order->id }}</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Người Dùng: {{ $order->user ? $order->user->name : 'N/A' }}</h5>
            <p class="card-text"><strong>Tổng Tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</p>
            <p class="card-text"><strong>Ngày Đặt Hàng:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</p>
            <p class="card-text"><strong>Trạng Thái:</strong> {{ ucfirst($order->status) }}</p>
            <h5 class="mt-4">Chi Tiết Sản Phẩm:</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Tên Sản Phẩm</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>
                                <a href="{{ route('products.show', $item->product->id) }}">
                                    {{ $item->product ? $item->product->name : 'N/A' }}
                                </a>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                            <td>{{ number_format($item->subtotal, 0, ',', '.') }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Trở về danh sách đơn hàng</a>
</div>
@endsection
