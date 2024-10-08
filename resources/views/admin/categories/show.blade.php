@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Chi tiết loại sản phẩm</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $category->name }}</h5>
            <p class="card-text"><strong>Mô tả:</strong> {{ $category->description }}</p>
            <p class="card-text"><strong>Số lượng sản phẩm:</strong> {{ $category->products->count() }}</p> <!-- Hiển thị số lượng sản phẩm thuộc loại này -->
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Sửa</a>
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa loại sản phẩm này?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>

    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Trở về danh sách loại sản phẩm</a>
</div>
@endsection
