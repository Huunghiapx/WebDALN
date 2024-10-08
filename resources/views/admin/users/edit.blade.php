@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Sửa Khách Hàng</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')  <!-- Thêm phương thức PUT để cập nhật -->

        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Tên khách hàng:') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email:') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="phone_number" class="col-md-4 col-form-label text-md-end">{{ __('Số điện thoại:') }}</label>

            <div class="col-md-6">
                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required>

                @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Địa chỉ:') }}</label>

            <div class="col-md-6">
                <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address">{{ old('address', $user->address) }}</textarea>

                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Ảnh khách hàng:') }}</label>

            <div class="col-md-6">
                <!-- Hiển thị hình ảnh hiện tại -->
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="img-fluid mb-2" style="max-width: 100px;">
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
