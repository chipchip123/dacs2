@extends('admin.layouts.layout')

@section('content')

<h3 class="mb-4">Sửa danh mục</h3>

<form method="POST" action="{{ route('admin.categories.update', $category->category_id) }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Tên danh mục</label>
        <input type="text" name="category_name" class="form-control"
               value="{{ $category->category_name }}" required>
    </div>

    <button class="btn btn-primary">Cập nhật</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
</form>

@endsection
