@extends('admin.layouts.layout')

@section('content')

<h3 class="mb-4">Quản lý danh mục</h3>

{{-- FORM TÌM KIẾM --}}
<form method="GET" action="{{ route('admin.categories.index') }}" class="mb-4">
    <div class="row g-3">

        <div class="col-md-4">
            <label class="form-label">Tìm theo tên danh mục</label>
            <input type="text" name="keyword" class="form-control"
                   value="{{ $keyword }}" placeholder="Nhập tên danh mục...">
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100">Tìm</button>
        </div>

    </div>
</form>

{{-- NÚT THÊM --}}
<a href="{{ route('admin.categories.create') }}" class="btn btn-success mb-3">
    + Thêm danh mục
</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- BẢNG HIỂN THỊ --}}
<table class="table table-bordered bg-white">
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên danh mục</th>
            <th>Số lượng sản phẩm</th>
            <th width="150px">Hành động</th>
        </tr>
    </thead>

    <tbody>
        @foreach($categories as $c)
        <tr>
            {{-- STT chuẩn theo trang --}}
            <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>

            <td>{{ $c->category_name }}</td>
             <td>{{ $c->products_count }}</td> <!-- 👈 Cột số lượng SP -->

            <td>
                <a href="{{ route('admin.categories.edit', $c->category_id) }}"
                   class="btn btn-warning btn-sm">Sửa</a>

                <a href="{{ route('admin.categories.delete', $c->category_id) }}"
                   onclick="return confirm('Xóa danh mục này?')"
                   class="btn btn-danger btn-sm">Xóa</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- PHÂN TRANG --}}
<div class="mt-3">
    {{ $categories->links() }}
</div>

@endsection
