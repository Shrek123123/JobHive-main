<div class="modal-header">
    <h4>Apply Form</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
</div>
<form method="post" action="submit_form.php" enctype="multipart/form-data">
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Họ và tên *</label>
            <input type="text" class="form-control" name="fullname" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email *</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Số điện thoại *</label>
            <input type="tel" class="form-control" name="phone" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tải CV lên</label>
            <input type="file" class="form-control" name="cv_file" accept=".pdf,.doc,.docx">
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="allow_search" id="allowSearch">
            <label class="form-check-label" for="allowSearch">
                Cho phép nhà tuyển dụng tìm bạn
            </label>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success w-100 ">Apply</button>
    </div>
    <p class="note mt-3">
        Bằng việc nhấn nút nộp hồ sơ tôi đồng ý chia sẻ thông tin cá nhân của mình với nhà tuyển dụng theo các
        <a href="#">Điều khoản sử dụng</a>,
        <a href="#">Chính sách bảo mật</a> và
        <a href="#">Chính sách dữ liệu cá nhân</a>.
    </p>
</form>