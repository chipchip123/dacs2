<div class="table-responsive">
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
            <tr>
                <th>STT</th>
                <th>Sản phẩm</th>
                <th>Người dùng</th>
                <th>Đánh giá</th>
                <th>Bình luận</th>
                <th>Phản hồi Admin</th>
                <th>Ngày tạo</th>
                <th width="150px">Hành động</th>
            </tr>
        </thead>

        <tbody>
            @forelse($reviews as $review)
                @php
                    $index = ($reviews->currentPage() - 1) * $reviews->perPage() + $loop->iteration;
                @endphp

                <tr>
                    <td>{{ $index }}</td>

                    <td>
                        {{ $review->product?->name ?? 'Sản phẩm đã xóa' }}
                    </td>

                    <td>
                        {{ $review->user?->name ?? 'User đã xóa' }}<br>
                        <small class="text-muted">{{ $review->user?->email }}</small>
                    </td>

                    <td>
                        {!! str_repeat('<span class="star-yellow">⭐</span>', $review->rating) !!}
                        {!! str_repeat('<span class="star-gray">⭐</span>', 5 - $review->rating) !!}
                        <br>
                        <small class="text-muted">{{ $review->rating }}/5</small>
                    </td>

                    <td>{{ $review->comment }}</td>

                    <td>
                        @if($review->admin_response)
                            <div class="alert alert-info small">
                                <strong>Đã phản hồi:</strong><br>
                                {{ Str::limit($review->admin_response, 80) }}

                                @if(strlen($review->admin_response) > 80)
                                    <a href="#"
                                        onclick="showResponse(event, '{{ addslashes($review->admin_response) }}', '{{ $review->admin_response_at }}')"
                                        class="small">Xem thêm</a>
                                @endif
                                <br>
                                <small class="text-muted">{{ $review->admin_response_at }}</small>
                            </div>
                        @else
                            <span class="text-danger">Chưa phản hồi</span>
                        @endif
                    </td>

                    <td>{{ $review->created_at }}</td>

                    <td>
                        @if(!$review->admin_response)
                            <button class="btn btn-success btn-sm"
                                onclick="openResponseModal({{ $review->review_id }}, '{{ addslashes($review->user->name ?? '') }}')">
                                Phản hồi
                            </button>
                        @else
                            <button class="btn btn-warning btn-sm"
                                onclick="openResponseModal({{ $review->review_id }}, '{{ addslashes($review->user->name ?? '') }}', '{{ addslashes($review->admin_response) }}')">
                                Sửa
                            </button>

                            <form action="{{ route('admin.reviews.response.delete', $review->review_id) }}" method="POST"
                                style="display:inline" onsubmit="return confirm('Xóa phản hồi?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-secondary btn-sm">Xóa phản hồi</button>
                            </form>
                        @endif

                        <form action="{{ route('admin.reviews.delete', $review->review_id) }}" method="POST"
                            style="display:inline" onsubmit="return confirm('Xóa đánh giá?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Xóa đánh giá</button>
                        </form>
                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Không có đánh giá nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $reviews->links() }}
</div>