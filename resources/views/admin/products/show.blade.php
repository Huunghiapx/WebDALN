@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Chi tiết sản phẩm</h1>

    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4">
                <!-- <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-start" alt="{{ $product->name }}"> -->
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded-start">

            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text"><strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
                    <p class="card-text"><strong>Số lượng:</strong> {{ $product->quantity }}</p>
                    <p class="card-text"><strong>Mô tả:</strong> {{ $product->description }}</p>
                    <p class="card-text"><strong>Loại sản phẩm:</strong> {{ optional($product->category)->name }}</p>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Sửa</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('products.index') }}" class="btn btn-secondary">Trở về danh sách sản phẩm</a>
    
</div>
@endsection
