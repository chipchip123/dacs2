@extends('admin.layouts.layout')

@section('content')

<h2 class="mb-4">📊 Dashboard Thống Kê</h2>

{{-- ========= DOANH THU TÓM TẮT ========= --}}
<div class="row">

    <div class="col-md-3">
        <div class="card p-3 shadow-sm text-center">
            <h5>Doanh thu tháng</h5>
            <h3 class="text-primary">
                {{ number_format($monthlyRevenue[now()->month] ?? 0) }} đ
            </h3>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card p-3 shadow-sm">
            <h5>📈 Doanh thu 12 tháng</h5>
            <canvas id="chartMonthly"></canvas>
        </div>
    </div>

</div>

<hr>

{{-- ========= DOANH THU + ORDER STATUS ========= --}}
<div class="row mt-4">

    <div class="col-md-6">
        <div class="card p-3 shadow-sm">
            <h5>📊 Doanh thu 7 ngày gần nhất</h5>
            <canvas id="chartWeekly"></canvas>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-3 shadow-sm">
            <h5>🧾 Tỉ lệ đơn hàng theo trạng thái</h5>
            <canvas id="chartStatus"></canvas>
        </div>
    </div>

</div>

<hr>

{{-- ========= TOP PRODUCTS ========= --}}
<div class="card p-3 shadow-sm mt-4">
    <h5>🔥 Top 5 sản phẩm bán chạy</h5>
    <canvas id="chartTopProducts"></canvas>
</div>

@endsection


{{-- ========================================= --}}
{{--             CHART.JS SCRIPTS             --}}
{{-- ========================================= --}}
@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // ================================
    // 1) DOANH THU 12 THÁNG
    // ================================
    new Chart(document.getElementById('chartMonthly'), {
        type: 'line',
        data: {
            labels: [...Array(12).keys()].map(i => `Tháng ${i+1}`),
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: @json(array_values($monthlyRevenue)),
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                tension: 0.4
            }]
        }
    });


    // ================================
    // 2) DOANH THU 7 NGÀY
    // ================================
    new Chart(document.getElementById('chartWeekly'), {
        type: 'bar',
        data: {
            labels: @json($last7Days->pluck('date')),
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: @json($last7Days->pluck('revenue')),
                backgroundColor: '#28a745'
            }]
        }
    });


    // ================================
    // 3) TỶ LỆ TRẠNG THÁI ĐƠN HÀNG
    // ================================
    new Chart(document.getElementById('chartStatus'), {
        type: 'pie',
        data: {
            labels: @json($orderStatus->pluck('status')),
            datasets: [{
                data: @json($orderStatus->pluck('total')),
                backgroundColor: ['#007bff', '#ffc107', '#28a745', '#dc3545']
            }]
        }
    });


    // ================================
    // 4) TOP SẢN PHẨM BÁN CHẠY
    // ================================
    new Chart(document.getElementById('chartTopProducts'), {
        type: 'bar',
        data: {
            labels: @json($topProducts->pluck('product.name')->map(fn($name) => $name ?? "Không rõ")),

            datasets: [{
                label: 'Số lượng bán',
                data: @json($topProducts->pluck('total_sold')),
                backgroundColor: '#ff5733'
            }]
        },
        options: { indexAxis: 'y' }
    });

</script>

@endsection
