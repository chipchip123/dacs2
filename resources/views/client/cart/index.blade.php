@extends('layouts.client')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container py-4">

    <h3 class="mb-4">🧺 Giỏ hàng của bạn</h3>

    @if(!$cart)
        <div class="alert alert-info">Giỏ hàng của bạn đang trống.</div>
    @else
        <table class="table table-bordered align-middle">
            <thead class="table-danger">
                <tr>
                    <th>Hình</th>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th width="120">Số lượng</th>
                    <th>Tổng</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @php $total = 0; @endphp

                @foreach($cart as $id => $item)
                    @php
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    @endphp

                    <tr>
                        <td>
                            <img src="{{ asset('images/' . $item['image']) }}" width="70">
                        </td>

                        <td>{{ $item['name'] }}</td>

                        <td class="text-danger fw-bold">{{ number_format($item['price']) }} ₫</td>

                        <td>
                            <input type="number" class="form-control cart-qty"
                                   data-id="{{ $id }}"
                                   value="{{ $item['quantity'] }}"
                                   min="1">
                        </td>

                        <!-- Subtotal có ID để cập nhật bằng AJAX -->
                        <td class="fw-bold" id="subtotal-{{ $id }}">
                            {{ number_format($subtotal) }} ₫
                        </td>

                        <td>
                            <a href="{{ route('cart.remove', $id) }}" class="btn btn-sm btn-outline-danger">
                                Xóa
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end mt-4">
            <h4>
                Tổng cộng:
                <span id="cart-total" class="text-danger fw-bold">
                    {{ number_format($total) }} ₫
                </span>
            </h4>
            

            <a href="/checkout" class="btn btn-danger btn-lg mt-3">
                Thanh toán ngay
            </a>
        </div>

    @endif
</div>
@endsection
