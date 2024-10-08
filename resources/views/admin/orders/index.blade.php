@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Danh Sách Đơn Hàng</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('orders.create') }}" class="btn btn-primary">Thêm Đơn Hàng</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách đơn hàng</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Khách Hàng</th>
                            <th>Số Lượng</th>
                            <th>Tổng Tiền</th>
                            <th>Ngày Đặt Hàng</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td><a href="{{ route('orders.show', $order->id) }}" class="btn btn-warning btn-sm" >Đơn hàng {{ $order->id }}</a></td>
                                <td>{{ $order->user ? $order->user->name : 'N/A' }}</td>
                                <td>{{ $order->items->sum('quantity') }}</td>
                                <td>{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>
                                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">Xóa</button>
                                    </form>
                                </td>
                            
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Trở về danh sách đơn hàng</a>

</div>
@endsection
