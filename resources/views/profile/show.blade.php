@extends('layouts.admin')

@section('content')

    <div class="container">
        <h1>Profile</h1>
        <p>Name: {{ $user->name }}</p>
        <p>Email: {{ $user->email }}</p>
        <p>Address: {{ $user->address }}</p>
        <p>Phone Number: {{ $user->phone }}</p>
        <!-- Thêm thông tin khác nếu cần -->
    </div>
@endsection
