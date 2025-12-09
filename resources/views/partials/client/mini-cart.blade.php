@php $cart = session('cart', []); @endphp

<h6 class="fw-bold">🧺 Giỏ hàng</h6>

@if(!$cart)
    <p class="text-muted">Giỏ hàng trống.</p>
@else
    @foreach($cart as $id => $item)
        <div class="d-flex align-items-center mb-2">
            <img src="{{ asset('images/'.$item['image']) }}" width="40" class="rounded">
            <div class="ms-2">
                <div class="fw-bold">{{ $item['name'] }}</div>
                <small>{{ $item['quantity'] }} x {{ number_format($item['price']) }}₫</small>
            </div>
            <a href="{{ route('cart.remove', $id) }}" class="ms-auto text-danger">
                <i class="bi bi-x-circle"></i>
            </a>
        </div>
        <hr>
    @endforeach

    <a href="/cart" class="btn btn-primary w-100 mb-2">Xem giỏ hàng</a>
    <a href="/checkout" class="btn btn-danger w-100">Thanh toán</a>
@endif
