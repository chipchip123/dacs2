@extends('layouts.client')

@section('title', 'Sản phẩm')

@section('content')

@include('partials.client.category-bar')

<div class="main-layout-wrapper">

    <!-- =============== LEFT SIDEBAR =============== -->
    <section class="left-sidebar">
        <form action="{{ url()->current() }}" method="GET">

            {{-- SEARCH BY NAME --}}
            <div class="search-name-container">
                <input type="text" name="search_name" class="search-name-input"
                       placeholder="Tìm theo tên món ăn..."
                       value="{{ request('search_name') }}">
            </div>

            {{-- PRICE FILTER --}}
            <table class="filter-table">
                <thead>
                    <tr><th colspan="2"><h2>Bộ lọc Giá</h2></th></tr>
                </thead>
                <tbody>

                    @php
                        $price = request('price_filter');
                    @endphp

                    <tr>
                        <td>Giá giảm dần</td>
                        <td class="radio-cell">
                            <input type="radio" name="price_filter" value="descending"
                                   {{ $price == 'descending' ? 'checked' : '' }}>
                        </td>
                    </tr>

                    <tr>
                        <td>Dưới 100.000₫</td>
                        <td><input type="radio" name="price_filter" value="under-100k"
                                   {{ $price == 'under-100k' ? 'checked' : '' }}></td>
                    </tr>

                    <tr>
                        <td>Dưới 200.000₫</td>
                        <td><input type="radio" name="price_filter" value="under-200k"
                                   {{ $price == 'under-200k' ? 'checked' : '' }}></td>
                    </tr>

                    <tr>
                        <td>Dưới 300.000₫</td>
                        <td><input type="radio" name="price_filter" value="under-300k"
                                   {{ $price == 'under-300k' ? 'checked' : '' }}></td>
                    </tr>

                    <tr>
                        <td>Trên 300.000₫</td>
                        <td><input type="radio" name="price_filter" value="above-300k"
                                   {{ $price == 'above-300k' ? 'checked' : '' }}></td>
                    </tr>

                </tbody>
            </table>

            <button class="search-button" type="submit">TÌM KIẾM</button>

        </form>
    </section>

    <!-- =============== MAIN AREA =============== -->
    <main class="products-main-content">

        <!-- SORT PRO -->
        <div class="d-flex justify-content-end mb-3">

            <form method="GET" action="{{ url()->current() }}" class="d-flex gap-3">

                {{-- KEEP FILTERS --}}
                <input type="hidden" name="search_name" value="{{ request('search_name') }}">
                <input type="hidden" name="price_filter" value="{{ request('price_filter') }}">

                @php
                    $sort = request('sort_by');
                @endphp

                <select name="sort_by" class="form-select" style="width:260px;"
                        onchange="this.form.submit()">

                    <option value="">-- Sắp xếp nâng cao --</option>

                    <option value="price-asc"  {{ $sort=='price-asc' ? 'selected' : '' }}>
                        Giá tăng dần
                    </option>

                    <option value="price-desc" {{ $sort=='price-desc' ? 'selected' : '' }}>
                        Giá giảm dần
                    </option>

                    <option value="name-asc" {{ $sort=='name-asc' ? 'selected' : '' }}>
                        Tên A → Z
                    </option>

                    <option value="name-desc" {{ $sort=='name-desc' ? 'selected' : '' }}>
                        Tên Z → A
                    </option>

                    <option value="sold-desc" {{ $sort=='sold-desc' ? 'selected' : '' }}>
                        Bán chạy nhất
                    </option>

                    <option value="newest" {{ $sort=='newest' ? 'selected' : '' }}>
                        Mới nhất
                    </option>

                    <option value="oldest" {{ $sort=='oldest' ? 'selected' : '' }}>
                        Cũ nhất
                    </option>

                </select>

            </form>

        </div>

        <!-- PRODUCT LIST -->
        <section class="products-section">

            <div class="product-grid">

                @forelse($products as $p)

                    <div class="product-item">
                        <div class="product-card">

                            <div class="product-image-container">
                                <img src="{{ asset('images/' . $p->image) }}" class="product-image">

                                <button class="btn btn-danger position-absolute bottom-0 end-0 m-2 add-to-cart"
                                        data-id="{{ $p->product_id }}">
                                    <i class="bi bi-cart-plus"></i>
                                </button>

                                <!-- RATING BADGE -->
                                @if($p->reviews_count > 0)
                                    <div class="rating-badge">
                                        <span class="rating-stars">
                                            @for($i = 0; $i < round($p->reviews_avg_rating); $i++)
                                                ★
                                            @endfor
                                        </span>
                                        <span class="rating-value">{{ number_format($p->reviews_avg_rating, 1) }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="product-info">
                                <h4>{{ $p->name }}</h4>
                                <p class="product-price">{{ number_format($p->price) }} VND</p>
                                
                                <!-- REVIEWS COUNT -->
                                <div class="reviews-info">
                                    @if($p->reviews_count > 0)
                                        <a href="{{ route('reviews.list', $p->product_id) }}" class="reviews-link">
                                            👁️ {{ $p->reviews_count }} đánh giá
                                        </a>
                                    @else
                                        <span class="text-muted">Chưa có đánh giá</span>
                                    @endif
                                </div>

                                <small>Đã bán: {{ $p->sold }}</small>
                            </div>

                        </div>
                    </div>

                @empty
                    <div class="no-products-found">
                        <p>Không tìm thấy sản phẩm phù hợp.</p>
                    </div>
                @endforelse

            </div>

            <div class="pagination-links mt-4">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>

        </section>

    </main>
</div>

<style>
    /* ========== RATING BADGE STYLES ========== */
    .rating-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: bold;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }

    .rating-stars {
        font-size: 0.95em;
        letter-spacing: -2px;
    }

    .rating-value {
        font-size: 0.9em;
        font-weight: 600;
    }

    /* ========== REVIEWS INFO STYLES ========== */
    .reviews-info {
        margin: 8px 0;
        padding: 6px 0;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
    }

    .reviews-link {
        color: #667eea;
        text-decoration: none;
        font-size: 0.9em;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-block;
    }

    .reviews-link:hover {
        color: #764ba2;
        text-decoration: underline;
        transform: translateX(2px);
    }

    .product-card {
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }
</style>

@endsection
