@extends('admin.layouts.layout')

@section('content')

<h3 class="mb-4">Chi tiết đơn hàng #{{ $order->order_id }}</h3>

{{-- Thông tin khách hàng --}}
<div class="card p-3 mb-4">
    <h5>Thông tin khách hàng</h5>

    <p><strong>Tên:</strong> {{ $order->user->name ?? 'Không có' }}</p>
    <p><strong>SĐT:</strong> {{ $order->user->phone ?? 'Không có' }}</p>
    <p><strong>Email:</strong> {{ $order->user->email ?? 'Không có' }}</p>
    <p><strong>Ngày tạo:</strong> {{ $order->created_at }}</p>

    {{-- Form cập nhật trạng thái --}}
    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->order_id) }}">
        @csrf

        <label class="mt-2">Trạng thái đơn:</label>
        <select name="status" class="form-select w-25">
            <option value="pending"    {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
            <option value="completed"  {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
        </select>

        <button class="btn btn-primary mt-3">Cập nhật trạng thái</button>
    </form>
</div>

{{-- Danh sách sản phẩm --}}
<div class="card p-3">
    <h5>Sản phẩm trong đơn</h5>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>STT</th>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>SL</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>{{ $item->product->name ?? 'Sản phẩm đã bị xóa' }}</td>

                <td>{{ number_format($item->price) }} đ</td>

                <td>{{ $item->quantity }}</td>

                <td>{{ number_format($item->quantity * $item->price) }} đ</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="text-end mt-3">Tổng tiền: 
        <strong class="text-success">
            {{ number_format($order->total_price) }} đ
        </strong>
    </h4>
</div>

@endsection
