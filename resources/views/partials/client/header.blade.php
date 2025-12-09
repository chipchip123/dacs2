<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm">
    <div class="container">

        <!-- LOGO -->
        <a class="navbar-brand fw-bold fs-4" href="/">
            🍔 CHIP FOOD
        </a>

        <!-- TOGGLER MOBILE -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- MENU -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item"><a href="/" class="nav-link">Trang chủ</a></li>
                <li class="nav-item"><a href="/products" class="nav-link">Sản phẩm</a></li>
                <li class="nav-item"><a href="/reviews" class="nav-link">Đánh giá</a></li>

                @if(Auth::check())
                    <li class="nav-item"><a href="/orders" class="nav-link">Đơn hàng của tôi</a></li>
                @endif

                <!-- ========================== CART ICON ========================== -->
                <li class="nav-item dropdown ms-3">
                    <a class="nav-link position-relative" href="#" id="cartDropdown" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">

                        <i class="bi bi-cart3 fs-5"></i>

                        <!-- BADGE GIỎ HÀNG -->
                        @php $cartCount = collect(session('cart', []))->sum('quantity'); @endphp
                        @if($cartCount > 0)
                        <span class="cart-count-badge position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $cartCount }}
                        </span>
                        @endif
                    </a>

                    <!-- MINI CART DROPDOWN -->
                    <ul id="mini-cart" class="dropdown-menu dropdown-menu-end p-3 shadow" style="width:320px;">
                        @include('partials.client.mini-cart')
                    </ul>
                </li>

                <!-- ========================== USER LOGIN ========================== -->
                @if(Auth::check())
                    <li class="nav-item dropdown ms-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                            <span class="me-1">👤</span> {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/profile">Trang cá nhân</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger fw-bold" href="/logout">Đăng xuất</a></li>
                        </ul>
                    </li>

                @else
                    <li class="nav-item ms-3">
                        <a href="/login" class="btn btn-outline-light btn-sm px-3">Đăng nhập</a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>

<!-- Padding tránh navbar đè lên nội dung -->
<div style="padding-top: 80px;"></div>
