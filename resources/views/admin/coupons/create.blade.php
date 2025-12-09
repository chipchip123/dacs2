@extends('admin.layouts.layout')

@section('content')

<h3 class="mb-4">Thêm mã giảm giá</h3>

<form method="POST" action="{{ route('admin.coupons.store') }}">
    @csrf

    <label class="fw-bold">Mã giảm giá</label>
    <input type="text" name="code" class="form-control" required>

    <label class="fw-bold mt-3">Giảm (%)</label>
    <input type="number" name="discount_value" class="form-control" min="1" max="100" required>

    <label class="fw-bold mt-3">Giảm tối đa (đ)</label>
    <input type="number" name="max_discount" class="form-control" required>

    <label class="fw-bold mt-3">Ngày hết hạn</label>
    <input type="date" name="expires_at" class="form-control" required>

    <button class="btn btn-success mt-3 px-4">Thêm mới</button>
</form>

@endsection
