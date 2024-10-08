@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Sửa sản phẩm</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')  <!-- Thêm phương thức PUT để cập nhật -->

        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Tên sản phẩm:') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}" required>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="price" class="col-md-4 col-form-label text-md-end">{{ __('Giá:') }}</label>

            <div class="col-md-6">
                <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price) }}" required>

                @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="quantity" class="col-md-4 col-form-label text-md-end">{{ __('Số lượng:') }}</label>

            <div class="col-md-6">
                <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', $product->quantity) }}" required>

                @error('quantity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Mô tả:') }}</label>

            <div class="col-md-6">
                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $product->description) }}</textarea>

                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Ảnh sản phẩm:') }}</label>

            <div class="col-md-6">
                <!-- Hiển thị hình ảnh hiện tại -->
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid mb-2" style="max-width: 100px;">
                </div>

                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
                @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <small class="form-text text-muted">Nếu không thay đổi, hãy để trống.</small>
            </div>
        </div>

        <div class="row mb-3">
            <label for="category" class="col-md-4 col-form-label text-md-end">{{ __('Loại sản phẩm:') }}</label>

            <div class="col-md-6">
                <select id="category" class="form-select @error('category_id') is-invalid @enderror" name="category_id" required>
                    <option value="" disabled>{{ __('Chọn loại sản phẩm') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>

                @error('category_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Cập nhật') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
