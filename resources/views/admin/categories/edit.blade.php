@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Sửa Loại Sản Phẩm</h1>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')  <!-- Phương thức PUT để cập nhật -->

        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Tên loại sản phẩm:') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $category->name) }}" required>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Mô tả:') }}</label>

            <div class="col-md-6">
                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $category->description) }}</textarea>

                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Cập nhật Loại Sản Phẩm') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
