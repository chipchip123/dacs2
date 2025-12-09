@extends('admin.layouts.layout')

@section('content')

<div class="container">

    <h3 class="mb-3">Danh sách đơn hàng</h3>

    {{-- Filter trạng thái --}}
    <form method="GET" action="{{ route('admin.orders.index') }}" class="row mb-4">

        <div class="col-md-4">
            <label for="">Lọc theo trạng thái:</label>
            <select name="status" class="form-select">
                <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>Tất cả</option>
                <option value="pending" {{ $statusFilter == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="processing" {{ $statusFilter == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                <option value="completed" {{ $statusFilter == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
            </select>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100">Lọc</button>
        </div>

    </form>

    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>STT</th>
                <th>Khách hàng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th width="130px">Hành động</th>
            </tr>
        </thead>

        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>

                {{-- tên user, tránh lỗi null --}}
                <td>{{ optional($order->user)->name ?? 'Không có' }}</td>

                <td>{{ number_format($order->total_price) }} đ</td>

                <td>
                    <span class="badge 
                        @if($order->status == 'pending') bg-warning
                        @elseif($order->status == 'processing') bg-info
                        @else bg-success
                        @endif">
                        {{ $order->status }}
                    </span>
                </td>

                <td>{{ $order->created_at }}</td>

                <td>
                    <a href="{{ route('admin.orders.detail', $order->order_id) }}" 
                       class="btn btn-sm btn-primary">
                        Xem
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- Phân trang --}}
    <div>
        {{ $orders->links() }}
    </div>

</div>

@endsection
