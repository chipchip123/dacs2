@extends('admin.layouts.layout')

@section('content')

<h2>📊 Dashboard</h2>

<div class="row mt-4">

    <div class="col-md-4">
        <div class="card p-4 text-center shadow">
            <h4>🛒 Tổng đơn hàng</h4>
            <h2>{{ $orderCount }}</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-4 text-center shadow">
            <h4>👥 Người dùng</h4>
            <h2>{{ $userCount }}</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-4 text-center shadow">
            <h4>💰 Doanh thu hôm nay</h4>
            <h2>{{ number_format($revenueToday) }} ₫</h2>
        </div>
    </div>

</div>

@endsection
