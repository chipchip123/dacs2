@extends('layouts.client')

@section('title', $product->name . ' - Đánh giá & Bình luận')

@section('content')

    <div class="container py-5">

        <!-- BREADCRUMB -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('product') }}">Sản phẩm</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <!-- PRODUCT HEADER -->
        <div class="row mb-5 pb-4 border-bottom">
            <div class="col-md-3">
                <img src="{{ asset('images/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}"
                    style="object-fit: cover; height: 200px;">
            </div>

            <div class="col-md-9">
                <h2 class="mb-3">{{ $product->name }}</h2>

                <div class="mb-3">
                    <span class="h4 text-danger">{{ number_format($product->price) }} ₫</span>
                </div>

                <!-- RATING STATS -->
                <div class="rating-stats mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="rating-summary">
                                <div style="font-size: 2.5em; font-weight: bold;">
                                    {{ number_format($avgRating, 1) }}
                                </div>
                                <div class="stars-lg mb-2">
                                    @for($i = 0; $i < floor($avgRating); $i++)
                                        <span style="color: #ffc107; font-size: 1.3em;">★</span>
                                    @endfor
                                    @if($avgRating - floor($avgRating) >= 0.5)
                                        <span style="color: #ffc107; font-size: 1.3em;">★</span>
                                    @endif
                                </div>
                                <p class="text-muted">{{ $totalReviews }} đánh giá</p>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <!-- RATING DISTRIBUTION -->
                            @for($i = 5; $i >= 1; $i--)
                                @php
                                    $count = $ratingStats[$i] ?? 0;
                                    $percent = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                @endphp
                                <div class="rating-bar mb-2">
                                    <div class="d-flex align-items-center">
                                        <span style="width: 60px;" class="text-end">
                                            {{ str_repeat('★', $i) }}<span
                                                style="color: #ddd;">{{ str_repeat('★', 5 - $i) }}</span>
                                        </span>
                                        <div class="progress flex-grow-1 mx-3" style="height: 8px;">
                                            <div class="progress-bar bg-warning" style="width: {{ $percent }}%"></div>
                                        </div>
                                        <span class="text-muted" style="width: 40px;">{{ $count }}</span>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="d-flex gap-2">
                    <a href="{{ route('reviews.create', $product->product_id) }}" class="btn btn-primary btn-lg">
                        📝 Viết đánh giá
                    </a>
                    <a href="{{ route('product') }}" class="btn btn-outline-secondary btn-lg">
                        ← Quay lại
                    </a>
                </div>
            </div>
        </div>

        <!-- FLASH MESSAGE -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- REVIEWS LIST -->
        <div class="reviews-section">
            <h3 class="mb-4">💬 Bình luận từ khách hàng ({{ $totalReviews }})</h3>

            @forelse($reviews as $review)
                <div class="review-card mb-4 p-4 border rounded" style="background-color: #f9f9f9;">

                    <!-- REVIEWER INFO -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-3"
                                    style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.1em;">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong class="d-block">{{ $review->user->name }}</strong>
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- DELETE BUTTON (CHỈ CÓ KHI LÀ CHÍNH REVIEW CỦA BẠN) -->
                        @if(Auth::check() && Auth::id() === $review->user_id)
                            <a href="{{ route('reviews.delete', $review->review_id) }}"
                                onclick="return confirm('Xóa đánh giá này?')" class="btn btn-sm btn-outline-danger">
                                Xóa
                            </a>
                        @endif
                    </div>

                    <!-- RATING -->
                    <div class="mb-2">
                        @for($i = 0; $i < $review->rating; $i++)
                            <span style="color: #ffc107; font-size: 1.2em;">★</span>
                        @endfor
                        @for($i = $review->rating; $i < 5; $i++)
                            <span style="color: #e9ecef; font-size: 1.2em;">★</span>
                        @endfor
                        <small class="text-muted ms-2">{{ $review->rating }}/5</small>
                    </div>

                    <!-- COMMENT -->
                    @if($review->comment)
                        <p class="review-comment mb-3" style="line-height: 1.6;">
                            {{ $review->comment }}
                        </p>
                    @endif

                    <!-- ADMIN RESPONSE -->
                    @if($review->admin_response)
                        <div class="admin-response mt-3 p-3 bg-info bg-opacity-10 border-start border-info border-4 rounded">
                            <div class="d-flex align-items-center mb-2">
                                <span
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3px 10px; border-radius: 12px; font-size: 0.85em; font-weight: bold;">
                                    ADMIN REPLY
                                </span>
                            </div>
                            <p class="mb-0" style="line-height: 1.6;">
                                {{ $review->admin_response }}
                            </p>
                            <small class="text-muted d-block mt-2">
                                Phản hồi ngày {{ \Carbon\Carbon::parse($review->admin_response_at)->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    @endif

                </div>
            @empty
                <div class="text-center py-5">
                    <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên!</p>
                    <a href="{{ route('reviews.create', $product->product_id) }}" class="btn btn-primary">
                        Viết đánh giá ngay
                    </a>
                </div>
            @endforelse

            <!-- PAGINATION -->
            @if($reviews->hasPages())
                <nav class="mt-5">
                    <div class="d-flex justify-content-center">
                        {{ $reviews->links() }}
                    </div>
                </nav>
            @endif

        </div>

    </div>

    <style>
        .review-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .review-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .admin-response {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .stars-lg {
            font-size: 1.5em;
        }
    </style>

@endsection