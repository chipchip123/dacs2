@extends('layouts.client')

@section('content')
    <div class="text-center mt-5">
        <h2>Thanh toán chuyển khoản</h2>
        <p>Số tiền: <b>{{ number_format($amount) }} đ</b></p>

        <img src="{{ $qrUrl }}" width="260" class="my-3" />

        <p><b>Nội dung chuyển khoản:</b> {{ $info }}</p>

        <p class="mt-3 text-primary">Hệ thống sẽ tự động xác nhận thanh toán...</p>
    </div>

    <script>
        const code = "{{ $info }}";

        setInterval(() => {
            fetch(`/payment/check/${code}`)
                .then(res => res.json())
                .then(data => {
                    if (data.paid === true) {

                        // XOÁ GIỎ HÀNG LOCAL STORAGE (nếu dùng)
                        localStorage.removeItem("cart");

                        // CHUYỂN ĐẾN TRANG ĐƠN HÀNG
                        window.location.href = "/orders";
                    }
                });
        }, 3000);
    </script>
@endsection