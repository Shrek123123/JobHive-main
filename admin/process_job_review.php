<?php
// admin/process_job_review.php
session_start();
require_once '../config.php'; // Điều chỉnh đường dẫn đến config.php

// --- Kiểm tra quyền Admin (quan trọng) ---
// if (!isset($_SESSION['usernameadmin'])) {
//     // Nếu không phải admin, chuyển hướng hoặc hiển thị lỗi
//     header('Location: ../index.php');
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['job_id']) && isset($_POST['action'])) {
    $jobId = intval($_POST['job_id']);
    $action = $_POST['action'];

    $newStatus = '';
    if ($action === 'approve') {
        $newStatus = 'approved';
    } elseif ($action === 'reject') {
        $newStatus = 'rejected';
    } else {
        // Hành động không hợp lệ
        echo "<script>alert('Invalid action!'); window.history.back();</script>";
        exit();
    }

    $stmt = $conn->prepare("UPDATE job SET status = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("si", $newStatus, $jobId);
        if ($stmt->execute()) {
            echo "<script>alert('Job has been " . $newStatus . " successfully!'); window.location.href = 'jobpending.php';</script>";
        } else {
            echo "<script>alert('Error updating job status: " . $stmt->error . "'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement: " . $conn->error . "'); window.history.back();</script>";
    }
    $conn->close();
    exit();
} else {
    // Yêu cầu không hợp lệ (không phải POST hoặc thiếu dữ liệu)
    echo "<script>alert('Invalid request!'); window.history.back();</script>";
    exit();
}
?>