@extends('layouts.client')

@section('title', 'Lịch sử đơn hàng')

@section('content')

<div class="container py-4">

    <h3 class="mb-4">📦 Lịch sử đơn hàng</h3>

    @if($orders->isEmpty())
        <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
    @else

        <table class="table table-bordered align-middle">
            <thead class="table-danger">
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày tạo</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->order_id }}</td>
                        <td>{{ date('d/m/Y H:i', strtotime($order->created_at)) }}</td>

                        <td class="fw-bold text-danger">
                            {{ number_format($order->total_price) }} ₫
                        </td>

                        <td>
                            @if($order->status == 'pending')
                                <span class="badge bg-warning text-dark">Đang chờ xử lý</span>
                            @elseif($order->status == 'processing')
                                <span class="badge bg-primary">Đang chuẩn bị</span>
                            @else
                                <span class="badge bg-success">Hoàn thành</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('orders.detail', $order->order_id) }}" 
                               class="btn btn-sm btn-outline-danger">
                               Xem chi tiết
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif

</div>

@endsection
