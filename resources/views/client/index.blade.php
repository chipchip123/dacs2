@extends('layouts.client')

@section('title', 'Trang chủ')

@section('content')

<!-- ======================= BANNER ======================= -->
<section class="slider-container">
    <div class="slide active">
        <img src="{{ asset('images/banner1.jpg') }}" alt="Banner 1">
    </div>
    <div class="slide">
        <img src="{{ asset('images/banner2.jpg') }}" alt="Banner 2">
    </div>
    <div class="slide">
        <img src="{{ asset('images/banner3.jpg') }}" alt="Banner 3">
    </div>
</section>

<!-- ======================= DANH MỤC ======================= -->
@include('partials.client.category-bar')


<!-- ======================= 🔥 TOP SẢN PHẨM BÁN CHẠY ======================= -->
<section class="highlight-line text-center my-4">
    <p class="highlight-text fs-4 fw-bold text-danger">🔥 Top sản phẩm bán chạy 🔥</p>
</section>

<section class="container my-5">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">

            @foreach($hotProducts as $p)
                <div class="swiper-slide">
                    <div class="card shadow-sm text-center border-0 h-100">

                        <div class="position-relative">
                            <img src="{{ asset('images/' . $p->image) }}"
                                class="card-img-top"
                                alt="{{ $p->name }}"
                                style="height: 200px; object-fit: cover; border-radius: 10px;">

                            <!-- 🔥 Nút thêm giỏ hàng CHUẨN -->
                            <button class="btn btn-danger position-absolute bottom-0 end-0 m-2 rounded-circle add-to-cart"
                                data-id="{{ $p->product_id }}">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">{{ $p->name }}</h5>
                            <p class="text-primary mb-1">{{ number_format($p->price) }} VND</p>
                            <small class="text-muted">Đã bán: {{ $p->sold }}</small>

                            @php
                                $avg = $p->avgRating() ?? 0;
                                $rounded = round($avg, 1);
                            @endphp

                            <div class="text-warning mt-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($rounded))
                                        <i class="bi bi-star-fill"></i>
                                    @elseif ($i - $rounded < 1)
                                        <i class="bi bi-star-half"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                                <small>({{ number_format($rounded, 1) }})</small>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>



<!-- ======================= 🆕 SẢN PHẨM MỚI ======================= -->
<section class="highlight-line text-center my-4">
    <p class="highlight-text fs-4 fw-bold text-danger">🆕 Những sản phẩm mới 🔥</p>
</section>

<section class="container my-5">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">

            @foreach($newProducts as $p)
                <div class="swiper-slide">
                    <div class="card shadow-sm text-center border-0 h-100">

                        <div class="position-relative">
                            <img src="{{ asset('images/' . $p->image) }}"
                                class="card-img-top"
                                alt="{{ $p->name }}"
                                style="height: 200px; object-fit: cover; border-radius: 10px;">

                            <!-- 🔥 Nút thêm giỏ hàng CHUẨN -->
                            <button class="btn btn-danger position-absolute bottom-0 end-0 m-2 rounded-circle add-to-cart"
                                data-id="{{ $p->product_id }}">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">{{ $p->name }}</h5>
                            <p class="text-primary mb-1">{{ number_format($p->price) }} VND</p>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

    </div>
</section>




<!-- ======================= 💬 PHẢN HỒI KHÁCH HÀNG ======================= -->
<section class="feedback my-5">
    <div class="container">
        <h2 class="text-center text-danger mb-4 fw-bold">💬 Phản hồi từ khách hàng</h2>

        <div class="row">

            @foreach($commentReviews as $product)
                <div class="col-md-4 mb-4">
                    <div class="card p-3 h-100 shadow-sm border-0 text-center">

                        <h5 class="text-primary fw-bold">{{ $product->name }}</h5>

                        @foreach($product->reviews as $review)
                            <p class="text-muted fst-italic">“{{ $review->comment }}”</p>

                            <div class="text-warning mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                @endfor
                            </div>

                            <small class="text-secondary mb-2 d-block">
                                — {{ $review->user->name ?? 'Khách hàng ẩn danh' }}
                            </small>

                            <hr>
                        @endforeach

                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>


<!-- ======================= ABOUT US ======================= -->
<section class="about-section py-5">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="fw-bold text-danger">🏠 Về Chúng Tôi</h2>
            <p class="text-muted">Khám phá hành trình và đam mê ẩm thực của chúng tôi</p>
        </div>

        <div class="row align-items-center">

            <div class="col-md-6 mb-4 mb-md-0">
                <img src="{{ asset('images/about-us.jpg') }}" class="img-fluid rounded-4 shadow-sm">
            </div>

            <div class="col-md-6">
                <h4 class="fw-bold mb-3 text-dark">Nhà hàng FoodHub – Nơi hương vị hội tụ</h4>

                <p class="text-secondary mb-3">
                    Được thành lập từ năm <strong>2015</strong>, FoodHub tự hào là chuỗi nhà hàng hiện đại, phục vụ nhanh chóng & chuyên nghiệp.
                </p>

                <p class="text-secondary mb-4">
                    Không chỉ là nơi thưởng thức món ăn, FoodHub còn là nơi bạn tận hưởng không gian ấm cúng và tiện lợi.
                </p>

                <div class="d-flex justify-content-between flex-wrap gap-3 mt-4">

                    <div class="feature-box">
                        <i class="bi bi-award-fill text-danger fs-3"></i>
                        <h6 class="fw-bold mt-2 mb-0">Chất lượng hàng đầu</h6>
                    </div>

                    <div class="feature-box">
                        <i class="bi bi-lightning-fill text-danger fs-3"></i>
                        <h6 class="fw-bold mt-2 mb-0">Phục vụ nhanh</h6>
                    </div>

                    <div class="feature-box">
                        <i class="bi bi-heart-fill text-danger fs-3"></i>
                        <h6 class="fw-bold mt-2 mb-0">Khách hàng là trọng tâm</h6>
                    </div>

                </div>

            </div>

        </div>

    </div>
</section>

@endsection
