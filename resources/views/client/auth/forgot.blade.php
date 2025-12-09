@extends('layouts.client')

@section('content')
<div class="container" style="max-width: 450px; margin-top: 50px;">
    <h3 class="text-center mb-4">Quên mật khẩu</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label>Email của bạn:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Gửi email đặt lại mật khẩu</button>
    </form>
</div>
@endsection
