@extends('admin.layouts.layout')

@section('content')

<h3 class="mb-4">Thêm sản phẩm</h3>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Tên sản phẩm</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Giá</label>
        <input type="number" name="price" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Danh mục</label>
        <select name="category_id" class="form-control" required>
            @foreach($categories as $c)
            <option value="{{ $c->category_id }}">{{ $c->category_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Ảnh sản phẩm</label>
        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
    </div>

    <img id="preview" src="#" class="mt-2" style="max-width:180px; display:none; border-radius:8px;">

    <button class="btn btn-primary mt-3">Thêm sản phẩm</button>

</form>

@endsection

@section('scripts')
<script>
function previewImage(event) {
    let img = document.getElementById('preview');
    img.src = URL.createObjectURL(event.target.files[0]);
    img.style.display = 'block';
}
</script>
@endsection
