@extends('layouts.client')

@section('content')
<div class="container" style="max-width: 500px; margin-top: 50px;">
    <h3 class="text-center mb-4">Đăng ký tài khoản</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $e)
                <div>{{ $e }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf

        <div class="mb-3">
            <label>Họ và tên:</label>
            <input type="text" name="name" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Số điện thoại:</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label>Địa chỉ:</label>
            <input type="text" name="address" class="form-control">
        </div>

        <div class="mb-3">
            <label>Mật khẩu:</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Nhập lại mật khẩu:</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button class="btn btn-danger w-100">Đăng ký</button>

        <p class="text-center mt-3">
            Đã có tài khoản? <a href="/login">Đăng nhập</a>
        </p>
    </form>
</div>
@endsection
