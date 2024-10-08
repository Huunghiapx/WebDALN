@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Thông tin chi tiết của {{ $user->name }}</h1>

    <table class="table">
        <tbody>
            <tr>
                <th scope="row">Tên:</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th scope="row">Email:</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th scope="row">Số điện thoại:</th>
                <td>{{ $user->phone_number }}</td>
            </tr>
            <tr>
                <th scope="row">Địa chỉ:</th>
                <td>{{ $user->address }}</td>
            </tr>
            <tr>
                <th scope="row">Ngày tạo:</th>
                <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            <tr>
                <th scope="row">Cập nhật lần cuối:</th>
                <td>{{ $user->updated_at->format('d-m-Y H:i') }}</td>
            </tr>
            <tr>
                <th scope="row">Ảnh:</th>
                <td>
                    @if($user->image)
                        <!-- <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="img-fluid" style="max-width: 100px;"> -->
                        <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="img-fluid mb-2" style="max-width: 100px;">

                    @else
                        <span>Không có ảnh</span>
                    @endif
                    
                </td>
            </tr>
            <tr>
                <th scope="row">Vai trò:</th>
                <td>{{ ucfirst($user->role) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="mt-4">
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Trở lại danh sách người dùng</a>
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Sửa thông tin</a>
        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">Xóa người dùng</button>
        </form>
    </div>
</div>
@endsection
