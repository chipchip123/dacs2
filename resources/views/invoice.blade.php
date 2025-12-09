<h2>HÓA ĐƠN THANH TOÁN</h2>
<p>Mã đơn: {{ $order->order_id }}</p>
<p>Tổng tiền: {{ $order->total_price }}đ</p>

<table border="1" width="100%" cellspacing="0">
    <tr>
        <th>Sản phẩm</th>
        <th>SL</th>
        <th>Giá</th>
        <th>Thành tiền</th>
    </tr>

    @foreach($items as $item)
    <tr>
        <td>{{ $item->product->name }}</td>
        <td>{{ $item->quantity }}</td>
        <td>{{ $item->price }}</td>
        <td>{{ $item->quantity * $item->price }}</td>
    </tr>
    @endforeach
</table>
