@extends('layouts.client')

@section('content')
<div class="container" style="max-width: 450px; margin-top: 50px;">
    <h3 class="text-center mb-4">Đặt lại mật khẩu</h3>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mật khẩu mới:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nhập lại mật khẩu:</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-success w-100">Cập nhật mật khẩu</button>
    </form>
</div>
@endsection
