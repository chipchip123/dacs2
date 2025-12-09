<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @yield('styles')

    <style>
        body {
            background: #f5f6fa;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .admin-sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #1e1e2d;
            color: #fff;
            padding-top: 25px;
            overflow-y: auto;
        }

        .admin-sidebar h3 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 35px;
        }

        .admin-sidebar a {
            color: #c4c4d0;
            padding: 13px 30px;
            display: block;
            text-decoration: none;
            transition: 0.2s;
        }

        .admin-sidebar a:hover,
        .admin-sidebar a.active {
            background: #343446;
            color: #fff;
        }

        .admin-main {
            margin-left: 250px;
            padding: 25px;
        }

        .admin-header {
            background: #fff;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 6px;
            margin-bottom: 25px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="admin-sidebar">
        <h3>ADMIN</h3>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            📊 Dashboard
        </a>

        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            📦 Sản phẩm
        </a>

        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            🗂 Danh mục
        </a>

        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            🧾 Đơn hàng
        </a>

        <a href="{{ route('admin.coupons.index') }}" class="{{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
            🎟 Mã giảm giá
        </a>

        <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            📝 Đánh giá
        </a>

        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            👥 Người dùng
        </a>

        <a href="{{ route('admin.statistics.index') }}" class="{{ request()->routeIs('admin.statistics.index') ? 'active' : '' }}">
            📈 Thống kê
        </a>

        <a href="/logout">🚪 Đăng xuất</a>
    </div>

    <!-- Main Content -->
    <div class="admin-main">

        <div class="admin-header">
            <h4>Quản trị hệ thống</h4>

            <div>
                <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->role }})
            </div>
        </div>

        {{-- Nội dung chính --}}
        @yield('content')
    </div>

    {{-- MODALS ĐƯỢC ĐẶT NGOÀI admin-main --}}
    @yield('modals')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')

</body>

</html>
