<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <!-- CSRF TOKEN -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        window.Laravel = { csrfToken: "{{ csrf_token() }}" }
    </script>


    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- CSS riêng -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

@if(session('success'))
<div class="alert alert-success text-center">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger text-center">
    {{ session('error') }}
</div>
@endif

@include('partials.client.header')

<main class="container py-4">
    @yield('content')
</main>

@include('partials.client.footer')

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- JS riêng -->
<script src="{{ asset('javascript/script.js') }}?v={{ time() }}"></script>


</body>
</html>
