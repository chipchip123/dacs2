@extends('layouts.client')

@section('content')
<div class="profile-wrapper">
    <div class="profile-card">

        <h3 class="profile-title">
            <i class="bi bi-person-circle"></i> Thông tin cá nhân
        </h3>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Họ và tên</label>
                <input type="text" name="name" class="form-control custom-input" value="{{ $user->name }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control custom-input" value="{{ $user->email }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-control custom-input" value="{{ $user->phone }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="address" class="form-control custom-input" value="{{ $user->address }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Mật khẩu mới (không bắt buộc)</label>
                <input type="password" name="password" class="form-control custom-input">
            </div>

            <button class="btn btn-danger w-100 py-2 custom-btn">Lưu thay đổi</button>
        </form>
    </div>
</div>
@endsection
