<form method="GET" action="{{ route('admin.reviews.index') }}" class="mb-4">
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Tìm theo sản phẩm hoặc người dùng</label>
            <input type="text" name="keyword" class="form-control" 
                   value="{{ $keyword }}" placeholder="Nhập tên sản phẩm hoặc người dùng...">
        </div>

        <div class="col-md-4">
            <label class="form-label">Lọc theo đánh giá</label>
            <select name="rating" class="form-control">
                <option value="all">Tất cả</option>
                @for($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" {{ $ratingFilter == $i ? 'selected' : '' }}>
                        {{ str_repeat('⭐', $i) }} ({{ $i }} sao)
                    </option>
                @endfor
            </select>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Tìm</button>
        </div>
    </div>
</form>
