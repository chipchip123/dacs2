@extends('layouts.client')

@section('title', 'Thanh toán')

@section('content')

<div class="container py-4">

    <h3 class="mb-4 checkout-title">🧾 Thanh toán đơn hàng</h3>

    <div class="row">

        <!-- LEFT: Customer info -->
        <div class="col-md-7">
            <div class="checkout-box p-4 mb-4">

                <h5 class="fw-bold mb-3 text-danger">👤 Thông tin người nhận</h5>

                <form method="POST" action="{{ route('checkout.process') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ auth()->user()->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ auth()->user()->phone ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Địa chỉ giao hàng</label>
                        <textarea name="address" class="form-control" rows="3" required></textarea>
                    </div>

                    <h5 class="fw-bold text-danger mt-4">💳 Phương thức thanh toán</h5>

                    <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="payment" value="cod" checked>
                        <label class="form-check-label">Thanh toán khi nhận hàng (COD)</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" value="banking">
                        <label class="form-check-label">Chuyển khoản ngân hàng</label>
                    </div>

                    <button type="submit" class="btn btn-danger btn-lg w-100 mt-4">
                        🛒 Đặt hàng ngay
                    </button>

                </form>

            </div>
        </div>

        <!-- RIGHT: Order summary -->
        <div class="col-md-5">
            <div class="checkout-summary p-4">

                <h5 class="fw-bold mb-3 text-danger">🛍️ Tóm tắt đơn hàng</h5>

                @php $total = 0; @endphp

                @foreach($cart as $id => $item)
                    @php
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    @endphp

                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <strong>{{ $item['name'] }}</strong>
                            <small class="text-muted">x {{ $item['quantity'] }}</small>
                        </div>
                        <div class="fw-bold text-danger">{{ number_format($subtotal) }} ₫</div>
                    </div>
                @endforeach

                <hr>

                <!-- Coupon input -->
                <label class="fw-bold">🎟️ Mã giảm giá</label>
                <div class="input-group mb-3">
                    <input type="text" id="coupon-code" class="form-control" placeholder="Nhập mã giảm giá...">
                    <button class="btn btn-outline-danger" id="apply-coupon">Áp dụng</button>
                </div>

                <!-- Discount area -->
                <div id="discount-area" style="display:none;">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold text-success">Giảm giá:</span>
                        <span id="discount-amount" class="fw-bold text-success">0 ₫</span>
                    </div>
                    <hr>
                </div>

                <!-- Final total -->
                <div class="d-flex justify-content-between">
                    <strong>Tổng cộng:</strong>
                    <strong id="final-total" class="text-danger">
                        {{ number_format($total) }} ₫
                    </strong>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
