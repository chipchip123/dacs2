{{-- MODAL PHẢN HỒI --}}
<div class="modal fade" id="responseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="responseForm" method="POST" action="">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        Phản hồi cho <span id="userNameModal"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <textarea name="admin_response" id="adminResponse" 
                              class="form-control" rows="5"
                              placeholder="Nhập phản hồi..." required></textarea>
                    <small class="text-muted">
                        <span id="charCount">0</span>/1000 ký tự
                    </small>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" id="saveResponseBtn">Lưu phản hồi</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- MODAL XEM FULL --}}
<div class="modal fade" id="viewResponseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Phản hồi đầy đủ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="fullResponse"></div>
            </div>
        </div>
    </div>
</div>
