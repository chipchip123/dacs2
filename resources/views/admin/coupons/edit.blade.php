@extends('admin.layouts.layout')

@section('content')

<h3 class="mb-4">Sửa mã giảm giá: {{ $coupon->code }}</h3>

<form method="POST" action="{{ route('admin.coupons.update', $coupon->id) }}">
    @csrf

    <label class="fw-bold">Mã giảm giá</label>
    <input type="text" name="code" value="{{ $coupon->code }}" class="form-control" required>

    <label class="fw-bold mt-3">Giảm (%)</label>
    <input type="number" name="discount_value" class="form-control"
           value="{{ $coupon->discount_value }}" min="1" max="100" required>

    <label class="fw-bold mt-3">Giảm tối đa (đ)</label>
    <input type="number" name="max_discount" class="form-control" value="{{ $coupon->max_discount }}" required>

    <label class="fw-bold mt-3">Ngày hết hạn</label>
    <input type="date" name="expires_at" class="form-control" value="{{ $coupon->expires_at }}" required>

    <label class="fw-bold mt-3">Trạng thái</label>
    <select name="active" class="form-select">
        <option value="1" {{ $coupon->active ? 'selected' : '' }}>Hoạt động</option>
        <option value="0" {{ !$coupon->active ? 'selected' : '' }}>Tắt</option>
    </select>

    <button class="btn btn-primary mt-3 px-4">Cập nhật</button>
</form>

@endsection
