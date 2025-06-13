<?php
session_start();
require_once 'config.php'; // chứa kết nối DB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $fullname     = trim($_POST['fullname']);
    $email        = trim($_POST['email']);
    $phone        = trim($_POST['phone']);
    $allowSearch  = isset($_POST['allow_search']) ? 1 : 0;

    // Giả định user đã login và có sẵn user_id & job_id (bạn cần truyền job_id qua hidden input hoặc session)
    $jobseeker_id = $_SESSION['user_id'] ?? null;
    $job_id       = $_POST['job_id'] ?? null;

    // Validate cơ bản
    if (!$jobseeker_id || !$job_id) {
        die("Thiếu thông tin người dùng hoặc công việc.");
    }

    // Xử lý upload CV nếu có
    $cvPath = null;
    if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/cv/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileTmp  = $_FILES['cv_file']['tmp_name'];
        $fileName = basename($_FILES['cv_file']['name']);
        $target   = $uploadDir . time() . "_" . $fileName;

        if (move_uploaded_file($fileTmp, $target)) {
            $cvPath = $target;
        }
    }

    // Chèn dữ liệu vào bảng application
    $stmt = $conn->prepare("INSERT INTO application (job_id, jobseeker_id, fullname, email, phone, cv_path, allow_search)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssi", $job_id, $jobseeker_id, $fullname, $email, $phone, $cvPath, $allowSearch);

    if ($stmt->execute()) {
        echo "✅ Ứng tuyển thành công!";
        // Có thể redirect về trang cảm ơn hoặc trang job
    } else {
        echo "❌ Lỗi khi ứng tuyển: " . $conn->error;
    }
}
?>
