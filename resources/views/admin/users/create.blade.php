@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Thêm Khách Hàng</h1>

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data"> {{-- Thêm enctype để hỗ trợ upload ảnh --}}
        @csrf

        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Tên khách hàng:') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required>

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
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required>

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
                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" required>

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
                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address">

                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Vai trò:') }}</label>

            <div class="col-md-6">
                <select id="role" name="role" class="form-control @error('role') is-invalid @enderror">
                    <option value="customer" selected>Customer</option>
                    <option value="admin">Admin</option>
                </select>

                @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Mật khẩu:') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Ảnh:') }}</label>

            <div class="col-md-6">
                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">

                @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Thêm khách hàng') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
