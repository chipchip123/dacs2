@extends('layouts.client')

@section('title', 'Đánh giá - ' . $product->name)

@section('content')

<div class="container py-5">

    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('product') }}">Sản phẩm</a></li>
            <li class="breadcrumb-item"><a href="{{ route('reviews.list', $product->product_id) }}">{{ $product->name }}</a></li>
            <li class="breadcrumb-item active">Viết đánh giá</li>
        </ol>
    </nav>

    <div class="row">
        <!-- PRODUCT PREVIEW (LEFT) -->
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h6 class="card-title">{{ $product->name }}</h6>
                    <p class="card-text text-danger fw-bold">
                        {{ number_format($product->price) }} ₫
                    </p>

                    @if(!$hasPurchased)
                        <div class="alert alert-warning py-2 px-3 mb-0" style="font-size: 0.85rem;">
                            ⚠️ Chỉ những khách hàng đã mua sản phẩm này mới có thể đánh giá
                        </div>
                    @else
                        <div class="alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                            ✓ Bạn đã mua sản phẩm này
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- REVIEW FORM (RIGHT) -->
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">📝 Viết đánh giá của bạn</h5>
                </div>

                <div class="card-body p-5">

                    <form action="{{ route('reviews.store', $product->product_id) }}" method="POST" id="reviewForm">
                        @csrf

                        <!-- RATING SELECTION -->
                        <div class="mb-5">
                            <label class="form-label fw-bold mb-3">Mức đánh giá của bạn</label>

                            <div class="rating-selector d-flex gap-3 align-items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="rating-option cursor-pointer" style="cursor: pointer;">
                                        <input type="radio" name="rating" value="{{ $i }}" class="d-none" required>
                                        <div class="stars-display" style="font-size: 2em; transition: 0.2s;">
                                            @for($j = 0; $j < $i; $j++)
                                                <span style="color: #ffc107;">★</span>
                                            @endfor
                                            @for($j = $i; $j < 5; $j++)
                                                <span style="color: #e9ecef;">★</span>
                                            @endfor
                                        </div>
                                        <small class="d-block text-center mt-1">
                                            @switch($i)
                                                @case(1) Tệ @break
                                                @case(2) Chung chung @break
                                                @case(3) Tạm được @break
                                                @case(4) Tốt @break
                                                @case(5) Tuyệt vời @break
                                            @endswitch
                                        </small>
                                    </label>
                                @endfor
                            </div>

                            @error('rating')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <!-- COMMENT FIELD -->
                        <div class="mb-4">
                            <label for="comment" class="form-label fw-bold">Bình luận (tùy chọn)</label>
                            <textarea name="comment" id="comment" class="form-control" rows="6"
                                placeholder="Chia sẻ trải nghiệm của bạn với sản phẩm này. Mô tả chất lượng, hương vị, vận chuyển, v.v..."
                                maxlength="1000"></textarea>

                            <small class="text-muted d-block mt-2">
                                <span id="charCount">0</span>/1000 ký tự
                            </small>

                            @error('comment')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- GUIDELINES -->
                        <div class="alert alert-light border mb-4" style="background-color: #f8f9fa;">
                            <h6 class="mb-3">💡 Hướng dẫn viết bình luận tốt:</h6>
                            <ul class="mb-0 ps-4">
                                <li>Hãy mô tả trải nghiệm thực tế của bạn</li>
                                <li>Nêu rõ ưu điểm và nhược điểm</li>
                                <li>Tránh spam hoặc nội dung không liên quan</li>
                                <li>Hôn nhân, chính trị, tôn giáo sẽ bị xóa</li>
                            </ul>
                        </div>

                        <!-- BUTTONS -->
                        <div class="d-flex gap-2 justify-content-center">
                            @if($hasPurchased)
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    Gửi đánh giá
                                </button>
                            @else
                                <button type="submit" class="btn btn-primary btn-lg px-5" disabled title="Bạn phải mua sản phẩm mới có thể đánh giá">
                                    Gửi đánh giá
                                </button>
                                <small class="text-danger align-self-center">Bạn cần mua sản phẩm để đánh giá</small>
                            @endif

                            <a href="{{ route('reviews.list', $product->product_id) }}" class="btn btn-outline-secondary btn-lg px-5">
                                Hủy
                            </a>
                        </div>

                    </form>

                </div>
            </div>

            <!-- PREVIOUS REVIEWS PREVIEW -->
            <div class="mt-5">
                <a href="{{ route('reviews.list', $product->product_id) }}" class="text-decoration-none">
                    <h6>← Xem các đánh giá khác</h6>
                </a>
            </div>

        </div>

    </div>

</div>

<style>
    .rating-selector {
        justify-content: flex-start;
    }

    .rating-option {
        text-align: center;
        padding: 15px;
        border-radius: 8px;
        transition: all 0.2s ease;
        background-color: #f9f9f9;
    }

    .rating-option:hover {
        background-color: #f0f0f0;
        transform: scale(1.05);
    }

    .rating-option input[type="radio"]:checked + .stars-display {
        animation: bounce 0.3s ease;
    }

    .rating-option input[type="radio"]:checked ~ small {
        color: #ffc107;
        font-weight: bold;
    }

    @keyframes bounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }

    .card {
        border-radius: 8px !important;
    }

    .form-label {
        color: #333;
    }

    textarea.form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>

<script>
    // Update character count
    document.getElementById('comment')?.addEventListener('input', function() {
        document.getElementById('charCount').textContent = this.value.length;
    });

    // Add visual feedback to rating selection
    document.querySelectorAll('input[name="rating"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.rating-option').forEach(opt => {
                opt.style.backgroundColor = '#f9f9f9';
            });
            this.parentElement.style.backgroundColor = '#e7f3ff';
            this.parentElement.style.borderColor = '#667eea';
        });
    });

    // Form validation
    document.getElementById('reviewForm')?.addEventListener('submit', function(e) {
        const rating = document.querySelector('input[name="rating"]:checked');
        if (!rating) {
            e.preventDefault();
            alert('Vui lòng chọn mức đánh giá!');
        }
    });
</script>

@endsection
