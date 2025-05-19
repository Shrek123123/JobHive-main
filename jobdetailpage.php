<?php
include_once 'config.php';

if (isset($_GET['id'])) {
    $job_id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM job WHERE id = ?");
    $stmt->bind_param("i", $job_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $job = $result->fetch_assoc();
    if (!$job) {
        echo "<p class='text-danger'>Không tìm thấy công việc.</p>";
        exit;
    }
} else {
    echo "<p class='text-danger'>Thiếu ID công việc.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết tuyển dụng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        .job-title { font-size: 24px; font-weight: bold; }
        .skill-tag {
            display: inline-block;
            background: #e0f3ff;
            color: #007bff;
            padding: 4px 8px;
            margin: 2px;
            border-radius: 4px;
            font-size: 13px;
        }
        .sidebar-title { font-weight: bold; margin-bottom: 10px; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.apply-btn').on('click', function() {
                $('#applyModal').modal('show');
                $('#applyFormContent').load('applyform.php');
            });
        });
    </script>
</head>
<body>
<header class="bg-danger text-white py-3">
    <div class="container">
        <?php require_once 'homepage/header.php' ?>
    </div>
</header>

<div class="container my-5">
    <div class="row">
        <!-- Left column -->
        <div class="col-lg-8 mb-4">
            <div class="bg-white p-4 shadow rounded">
                <h5 class="fw-bold"><?= htmlspecialchars($job['title']) ?></h5>
                <small class="text-muted">Lương: <?= number_format($job['salary']) ?> USD</small>
                <hr>
                <p><strong>Địa điểm:</strong> <?= htmlspecialchars($job['location']) ?></p>
                <p><strong>Ngành:</strong> <?= htmlspecialchars($job['industry']) ?></p>
                <p><strong>Kinh nghiệm:</strong> <?= htmlspecialchars($job['experience_level']) ?></p>
                <p><strong>Hình thức:</strong> <?= htmlspecialchars($job['job_type']) ?></p>
                <p><strong>Làm việc:</strong> <?= htmlspecialchars($job['remote']) ?></p>

                <h4 class="text-danger mt-4">Mô tả công việc</h4>
                <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>

                <div class="mt-3">
                    <button class="btn btn-danger apply-btn">Ứng tuyển ngay</button>
                    <a href="#" class="btn btn-secondary">Lưu tin</a>
                </div>

                <!-- Modal ứng tuyển -->
                <div class="modal fade" id="applyModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" id="applyFormContent">
                            <div class="modal-body text-center p-10">
                                <div class="spinner-border" role="status"></div>
                                <p>Đang tải form...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right column -->
        <div class="col-lg-4">
            <div class="bg-white p-3 mb-4 shadow rounded">
                <div class="sidebar-title">Thông tin chung</div>
                <p><strong>Ngày đăng:</strong> <?= date('d/m/Y', strtotime($job['created_at'])) ?></p>
                <p><strong>Loại công việc:</strong> <?= htmlspecialchars($job['job_type']) ?></p>
                <p><strong>Hình thức:</strong> <?= htmlspecialchars($job['remote']) ?></p>
            </div>

            <div class="bg-white p-3 shadow rounded">
                <div class="sidebar-title">Địa điểm</div>
                <span class="skill-tag"><?= htmlspecialchars($job['location']) ?></span>
            </div>
        </div>
    </div>
</div>

<footer>
    <?php require_once 'homepage/footer.php' ?>
</footer>
</body>
</html>
