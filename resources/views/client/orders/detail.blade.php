@extends('layouts.client')

@section('title', 'Chi tiết đơn hàng')

@section('content')

    <div class="container py-4">

        <h3 class="mb-4">🧾 Chi tiết đơn #{{ $order->order_id }}</h3>

        <p><strong>Ngày tạo:</strong> {{ date('d/m/Y H:i', strtotime($order->created_at)) }}</p>

        <p><strong>Trạng thái:</strong>
            @if($order->status == 'pending')
                <span class="badge bg-warning text-dark">Đang chờ xử lý</span>
            @elseif($order->status == 'processing')
                <span class="badge bg-primary">Đang chuẩn bị</span>
            @else
                <span class="badge bg-success">Hoàn thành</span>
            @endif
        </p>

        <table class="table table-bordered align-middle mt-3">
            <thead class="table-danger">
                <tr>
                    <th>Hình</th>
                    <th>Sản phẩm</th>
                    <th>SL</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>

            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            <img src="{{ asset('images/' . $item->product->image) }}" width="70">
                        </td>

                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>

                        <td>{{ number_format($item->price) }} ₫</td>

                        <td class="fw-bold">
                            {{ number_format($item->price * $item->quantity) }} ₫
                        </td>

                        <td class="text-center">
                            @if($order->status == 'completed')
                                <a href="{{ route('reviews.create', $item->product->product_id) }}"
                                    class="btn btn-sm btn-outline-primary" title="Đánh giá sản phẩm này">
                                    📝 Đánh giá
                                </a>
                                <a href="{{ route('reviews.list', $item->product->product_id) }}"
                                    class="btn btn-sm btn-outline-secondary" title="Xem đánh giá">
                                    👁️ Xem
                                </a>
                            @else
                                <span class="text-muted small">Chờ hoàn thành</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4 class="text-end mt-4">
            Tổng thanh toán:
            <span class="text-danger fw-bold">{{ number_format($order->total_price) }} ₫</span>
        </h4>

        {{-- BACK BUTTON --}}
        <div class="mt-4">
            <a href="{{ route('orders.history') }}" class="btn btn-outline-secondary">
                ← Quay lại danh sách đơn hàng
            </a>
        </div>

    </div>

    <style>
        .btn-sm {
            padding: 0.35rem 0.65rem;
            font-size: 0.8rem;
        }

        .table td {
            vertical-align: middle;
        }
    </style>

@endsection