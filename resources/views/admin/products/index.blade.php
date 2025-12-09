@extends('admin.layouts.layout')

@section('content')

    <h3 class="mb-4">Quản lý sản phẩm</h3>

    {{-- FORM TÌM KIẾM + LỌC DANH MỤC --}}
    <form method="GET" action="{{ route('admin.products.index') }}" class="mb-4">

        <div class="row g-3">

            {{-- TÌM THEO TÊN --}}
            <div class="col-md-4">
                <label class="form-label">Tìm theo tên sản phẩm</label>
                <input type="text" name="keyword" class="form-control" value="{{ $keyword }}"
                    placeholder="Nhập tên sản phẩm...">
            </div>

            {{-- LỌC THEO DANH MỤC --}}
            <div class="col-md-4">
                <label class="form-label">Lọc theo danh mục</label>
                <select name="category" class="form-control">
                    <option value="all">Tất cả</option>

                    @foreach($categories as $c)
                        <option value="{{ $c->category_id }}" {{ $categoryFilter == $c->category_id ? 'selected' : '' }}>
                            {{ $c->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- NÚT TÌM --}}
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-primary w-100">Tìm</button>
            </div>

        </div>

    </form>

    {{-- NÚT THÊM --}}
    <a href="{{ route('admin.products.create') }}" class="btn btn-success mb-3">
        + Thêm sản phẩm
    </a>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- BẢNG HIỂN THỊ SẢN PHẨM --}}
    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>STT</th>
                <th>Ảnh</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th width="150px">Hành động</th>
            </tr>
        </thead>

        <tbody>
            @foreach($products as $p)
                <tr>

                    {{-- STT --}}
                    <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>

                    {{-- ẢNH --}}
                    <td>
                        @if($p->image)
                            <img src="{{ asset('images/' . $p->image) }}" width="60" height="60" style="object-fit: cover;">
                        @else
                            <span class="text-muted">Không có ảnh</span>
                        @endif
                    </td>

                    {{-- TÊN --}}
                    <td>{{ $p->name }}</td>

                    {{-- GIÁ --}}
                    <td>{{ number_format($p->price) }} đ</td>

                    {{-- DANH MỤC --}}
                    <td>{{ $p->category_name }}</td>

                    {{-- ACTION --}}
                    <td>
                        <a href="{{ route('admin.products.edit', $p->product_id) }}" class="btn btn-warning btn-sm">Sửa</a>

                        <a href="{{ route('admin.products.delete', $p->product_id) }}"
                            onclick="return confirm('Xóa sản phẩm này?')" class="btn btn-danger btn-sm">
                            Xóa
                        </a>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- PHÂN TRANG --}}
    <div class="mt-3">
        {{ $products->links() }}
    </div>

@endsection