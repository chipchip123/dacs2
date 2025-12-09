@extends('layouts.client')

@section('content')
<div class="container" style="max-width: 450px; margin-top: 50px;">
    <h3 class="text-center mb-4">Đăng nhập</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mật khẩu:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <a href="{{ route('password.request') }}" class="d-block text-end mb-2">Quên mật khẩu?</a>

        <button class="btn btn-danger w-100">Đăng nhập</button>

        <p class="text-center mt-3">
            Chưa có tài khoản? <a href="/register">Đăng ký</a>
        </p>
    </form>
</div>
@endsection
