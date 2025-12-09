@extends('admin.layouts.layout')

@section('content')

<h3 class="mb-4">Quản lý khách hàng</h3>

{{-- Tìm kiếm --}}
<form method="GET" class="row mb-4">

    <div class="col-md-4">
        <label class="fw-bold">Tìm kiếm khách hàng</label>
        <input type="text" name="keyword" class="form-control"
               value="{{ $keyword }}" placeholder="Nhập tên, email hoặc số điện thoại...">
    </div>

    <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-success w-100">Tìm kiếm</button>
    </div>

</form>

{{-- Gửi mail toàn bộ --}}
<div class="bg-white p-3 rounded shadow-sm mb-4">
    <h5 class="mb-3">📩 Gửi email cho tất cả khách hàng</h5>

    <form method="POST" action="{{ route('admin.users.sendMailAll') }}">
        @csrf

        <input type="text" name="subject" class="form-control mb-2" placeholder="Tiêu đề email" required>
        <textarea name="message" class="form-control mb-2" rows="3" placeholder="Nội dung email" required></textarea>

        <button class="btn btn-primary">Gửi email</button>
    </form>
</div>

{{-- Danh sách --}}
<div class="table-responsive bg-white p-3 rounded shadow-sm">
<table class="table table-bordered align-middle">
    <thead class="table-light">
        <tr>
            <th>STT</th>
            <th>Tên</th>
            <th>Email</th>
            <th>SĐT</th>
            <th>Địa chỉ</th>
            <th>Lượt mua</th>
            <th>Gửi mail</th>
        </tr>
    </thead>

    <tbody>
        @foreach($users as $index => $user)
        <tr>
            <td>{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>

            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->address }}</td>
            <td>{{ $user->orders_count }}</td>

            <td>
                <button class="btn btn-sm btn-primary"
                        data-action="{{ route('admin.users.sendMailOne', $user->user_id) }}"
                        data-email="{{ $user->email }}"
                        onclick="openMailForm(this)">
                    Gửi
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
    {{ $users->links() }}
</div>

</div>

{{-- Modal --}}
<div class="modal fade" id="mailModal">
    <div class="modal-dialog">
        <form method="POST" id="mailForm">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">📨 Gửi email cho: <span id="mailUser"></span></h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text" name="subject" class="form-control mb-2" placeholder="Tiêu đề email" required>
                    <textarea name="message" class="form-control" rows="4" placeholder="Nội dung email..." required></textarea>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Gửi email</button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
function openMailForm(button) {
    document.getElementById('mailUser').innerText = button.dataset.email;
    document.getElementById('mailForm').action = button.dataset.action;

    new bootstrap.Modal(document.getElementById('mailModal')).show();
}
</script>

@endsection
