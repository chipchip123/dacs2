function openResponseModal(reviewId, userName, existingResponse = '') {
    const form = document.getElementById('responseForm');
    const textarea = document.getElementById('adminResponse');
    const titleSpan = document.getElementById('userNameModal');
    const saveButton = document.getElementById('saveResponseBtn');

    titleSpan.textContent = userName;
    textarea.value = existingResponse || '';

    form.action = "/admin/reviews/" + reviewId + "/response";

    saveButton.textContent = existingResponse ? 'Cập nhật phản hồi' : 'Lưu phản hồi';

    updateCharCount();

    const modal = new bootstrap.Modal(document.getElementById('responseModal'));
    modal.show();
    textarea.focus();
}


function showResponse(event, responseText, responseDate) {
    event.preventDefault();

    const fullResponse = document.getElementById('fullResponse');
    const date = new Date(responseDate);

    const formattedDate = `${date.toLocaleDateString('vi-VN')} ${date.toLocaleTimeString('vi-VN')}`;

    fullResponse.innerHTML = `
        <p><strong>Phản hồi:</strong></p>
        <p style="white-space: pre-wrap;">${responseText}</p>
        <hr>
        <small class="text-muted">Ngày phản hồi: ${formattedDate}</small>
    `;

    const modal = new bootstrap.Modal(document.getElementById('viewResponseModal'));
    modal.show();
}


function updateCharCount() {
    const textarea = document.getElementById('adminResponse');
    const charCount = document.getElementById('charCount');
    const maxLength = 1000;

    let currentLength = textarea.value.length;

    if (currentLength > maxLength) {
        textarea.value = textarea.value.substring(0, maxLength);
        currentLength = maxLength;
    }

    charCount.textContent = currentLength;
}

document.getElementById('adminResponse')?.addEventListener('input', updateCharCount);
