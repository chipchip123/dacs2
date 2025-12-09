@extends('admin.layouts.layout')

@section('content')

<h3 class="mb-4">Thêm danh mục</h3>

<form method="POST" action="{{ route('admin.categories.store') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Tên danh mục</label>
        <input type="text" name="category_name" class="form-control" required>
    </div>

    <button class="btn btn-success">Thêm</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
</form>

@endsection
