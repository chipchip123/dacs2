@extends('admin.layouts.layout')

@section('content')

<h3 class="mb-4">Danh sách mã giảm giá</h3>

<a href="{{ route('admin.coupons.create') }}" class="btn btn-primary mb-3">
    + Thêm mã
</a>

<form method="GET" class="row mb-4">

    <div class="col-md-4">
        <label class="fw-bold">Tìm theo mã</label>
        <input type="text" name="keyword" value="{{ $keyword }}" class="form-control" placeholder="Nhập mã coupon...">
    </div>

    <div class="col-md-4">
        <label class="fw-bold">Lọc trạng thái</label>
        <select name="status" class="form-select">
            <option value="">Tất cả</option>
            <option value="active"  {{ $status == 'active' ? 'selected' : '' }}>Hoạt động</option>
            <option value="expired" {{ $status == 'expired' ? 'selected' : '' }}>Hết hạn</option>
        </select>
    </div>

    <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-success w-100">Lọc</button>
    </div>

</form>


<table class="table table-bordered table-striped bg-white">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã</th>
            <th>Giảm (%)</th>
            <th>Giảm tối đa (đ)</th>
            <th>Hết hạn</th>
            <th>Trạng thái</th>
            <th width="150px">Hành động</th>
        </tr>
    </thead>

    <tbody>
        @foreach($coupons as $coupon)
        <tr>
            <td>{{ $loop->iteration }}</td>

            <td>{{ $coupon->code }}</td>
            <td>{{ $coupon->discount_value }}%</td>
            <td>{{ number_format($coupon->max_discount) }} đ</td>
            <td>{{ $coupon->expires_at }}</td>

            <td>
                <span class="badge bg-{{ $coupon->active ? 'success' : 'secondary' }}">
                    {{ $coupon->active ? 'Hoạt động' : 'Hết hạn' }}
                </span>
            </td>

            <td>
                <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                <a onclick="return confirm('Xóa mã này?')" href="{{ route('admin.coupons.delete', $coupon->id) }}" class="btn btn-danger btn-sm">Xóa</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
    {{ $coupons->links() }}
</div>

@endsection
