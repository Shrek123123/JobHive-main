<?php
require_once 'config.php';
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
        body {
            background-color: #f8f9fa;
        }

        .job-title {
            font-size: 24px;
            font-weight: bold;
        }

        .tag {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            margin-right: 10px;
        }

        .skill-tag {
            display: inline-block;
            background: #e0f3ff;
            color: #007bff;
            padding: 4px 8px;
            margin: 2px;
            border-radius: 4px;
            font-size: 13px;
        }

        .sidebar-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX load applyform.php -->
    <script>
        $(document).ready(function () {
            $('.apply-btn').on('click', function () {
                $('#applyModal').modal('show');
                $('#applyFormContent').load('applyform.php');
            });
        });
    </script>
</head>

<body>

    <header>
        <?php require_once 'homepage/header.php' ?>
    </header>
    <div>

    </div>
    <div class="container my-5">
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8 mb-4">
                <div class="bg-white p-4 shadow rounded">
                    <?php

                    // Lấy id từ URL
                    $job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

                    // Lấy thông tin job
                    $job = null;
                    if ($job_id > 0) {
                        $stmt = $conn->prepare("SELECT * FROM job WHERE id = ?");
                        $stmt->bind_param("i", $job_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $job = $result->fetch_assoc();
                        $stmt->close();
                    }

                    // Lấy số người quan tâm
                    $interest_count = 0;
                    $stmt2 = $conn->prepare("SELECT interest_count FROM job_interest_count WHERE job_id = ?");
                    $stmt2->bind_param("i", $job_id);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    if ($row = $result2->fetch_assoc()) {
                        $interest_count = $row['interest_count'];
                    }
                    $stmt2->close();

                    // Tính ngày hết hạn
                    $job_deadline = '';
                    if ($job && isset($job['created_at']) && isset($job['post_duration'])) {
                        $created_at = new DateTime($job['created_at']);
                        $created_at->modify('+' . intval($job['post_duration']) . ' days');
                        $job_deadline = $created_at->format('d/m/Y');
                    }
                    ?>
                    <div class="bg-white p-3 mb-4 shadow rounded ">
                        <h5 class="fw-bold"><?= htmlspecialchars($job['job_title'] ?? 'Không có mô tả') ?></h5>
                        <small class="text-muted">There have been <?= $interest_count ?> people interested in this job,
                            apply now to not miss it!</small>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4 d-flex align-items-center">
                                <i class="bi bi-currency-dollar me-2"></i> <strong>Mức lương</strong>
                            </div>
                            <div class="col-md-8 text-danger fw-bold">
                                <?= htmlspecialchars($job['salary'] ?? 'Negotiable') ?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 d-flex align-items-center">
                                <i class="bi bi-geo-alt me-2"></i> <strong>Địa điểm</strong>
                            </div>
                            <div class="col-md-8"><?= htmlspecialchars($job['job_location'] ?? 'No data') ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 d-flex align-items-center">
                                <i class="bi bi-person-workspace me-2"></i> <strong>Kinh nghiệm</strong>
                            </div>
                            <div class="col-md-8"><?= htmlspecialchars($job['job_experience'] ?? 'No requirement') ?>
                            </div>
                        </div>
                        <div class="text-muted mb-3">
                            <i class="bi bi-calendar-event me-2"></i> Hạn nộp hồ sơ: <?= $job_deadline ?>
                        </div>
                        <?php
                        $is_logged_in = isset($_SESSION['username']) && $_SESSION['role'] === 'jobseeker';
                        $job_detail_id = isset($job['id']) ? intval($job['id']) : 0;

                        // Chuẩn bị URL gốc để quay lại sau login
                        $current_url = "jobdetail.php?id=" . urlencode($job_detail_id);
                        $login_url = "jobseekerlogin.php?redirect=" . urlencode($current_url);
                        ?>

                        <div class="d-flex gap-3">
                            <button class="btn btn-danger apply-btn" <?php if (!$is_logged_in): ?>
                                    onclick="window.location.href='<?= $login_url ?>'; return false;" <?php else: ?>
                                    data-job-id="<?= $job_detail_id ?>" <?php endif; ?>>Apply now</button>

                            <button class="btn btn-secondary" type="button" id="save-job-btn"
                                data-job-id="<?= $job_detail_id ?>" <?php if (!$is_logged_in): ?>
                                    onclick="window.location.href='<?= $login_url ?>'; return false;" <?php endif; ?>>
                                <span id="save-job-icon">&#9734;</span> Save job
                            </button>

                        </div>

                    </div>

                    <h2 class="text-danger mt-4">Job description</h2>
                    <p><?= nl2br(htmlspecialchars($job['job_description'] ?? 'No description available')) ?></p>


                    <h2 class="text-danger mt-4">Employee requirement</h2>
                    <p><?= nl2br(htmlspecialchars($job['job_requirement'] ?? 'No requirement specified')) ?></p>

                    <h2 class="text-danger mt-4">Job benefits</h2>
                    <p><?= nl2br(htmlspecialchars($job['job_benefit'] ?? 'No benefits specified')) ?></p>


                    <!-- Modal xử lý nút Apply-->
                    <div class="modal fade " id="applyModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" id="applyFormContent">
                                <!-- Nội dung form sẽ được load ở đây -->
                                <div class="modal-body text-center p-10">
                                    <div class="spinner-border" role="status"></div>
                                    <p>Loading...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Việc làm liên quan -->
                <?php
                // Lấy các việc làm liên quan cùng job_category (trừ chính job hiện tại)
                $related_jobs = [];
                if ($job && !empty($job['job_category'])) {
                    $stmt_related = $conn->prepare("SELECT id, job_title, salary FROM job WHERE job_category = ? AND id != ? LIMIT 5");
                    $stmt_related->bind_param("si", $job['job_category'], $job_id);
                    $stmt_related->execute();
                    $result_related = $stmt_related->get_result();
                    while ($row = $result_related->fetch_assoc()) {
                        $related_jobs[] = $row;
                    }
                    $stmt_related->close();
                }
                ?>

                <?php if (!empty($related_jobs)): ?>
                    <div class="bg-white p-4 shadow rounded mt-5">
                        <h4 class="text-danger">Related Jobs</h4>
                        <div class="list-group">
                            <?php foreach ($related_jobs as $rjob): ?>
                                <a href="jobdetail.php?id=<?= htmlspecialchars($rjob['id']) ?>"
                                    class="list-group-item list-group-item-action">
                                    <?= htmlspecialchars($rjob['job_title']) ?>: <?= htmlspecialchars($rjob['salary']) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>


            <!-- Right Column -->
            <div class="col-lg-4">
                <div class="bg-white p-3 mb-4 shadow rounded">
                    <?php if ($job): ?>
                        <div class="d-flex align-items-center mb-3">
                            <img src="<?= htmlspecialchars($job['company_logo'] ?? 'image/logo1.png') ?>" alt="Company Logo"
                                class="me-3 rounded" style="width: 80px; height: 80px;">
                            <div class="sidebar-title mb-0">
                                <h4><?= htmlspecialchars($job['company_name'] ?? 'Company Name') ?></h4>
                                <p><strong>Company size:</strong> <?= htmlspecialchars($job['company_size'] ?? 'Unknown') ?>
                                </p>
                                <p><strong>Industry:</strong> <?= htmlspecialchars($job['job_category'] ?? 'Unknown') ?></p>
                                <p><strong>Address:</strong>
                                    <?= htmlspecialchars($job['job_detailed_location'] ?? 'Unknown') ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="bg-white p-3 mb-4 shadow rounded">
                    <div class="sidebar-title">General Information</div>
                    <p><strong>Position level:</strong> <?= htmlspecialchars($job['job_position'] ?? 'N/A') ?></p>
                    <p><strong>Education:</strong> <?= htmlspecialchars($job['required_certification'] ?? 'N/A') ?></p>
                    <p><strong>Quantity:</strong> <?= htmlspecialchars($job['no_employee_needed'] ?? 'N/A') ?> person(s)
                    </p>
                    <p><strong>Type:</strong> <?= htmlspecialchars($job['job_type'] ?? 'N/A') ?></p>
                </div>

                <div class="bg-white p-3 mb-4 shadow rounded">
                    <div class="sidebar-title">Contact Information</div>
                    <p><strong>Email:</strong> <?= htmlspecialchars($job['contact_email'] ?? 'N/A') ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($job['contact_phone'] ?? 'N/A') ?></p>
                </div>

                <div class="bg-white p-3 shadow rounded">
                    <div class="sidebar-title">Location</div>
                    <?php if ($job): ?>
                        <?php if (!empty($job['job_location'])): ?>
                            <span class="skill-tag"><?= htmlspecialchars($job['job_location']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($job['job_location_district'])): ?>
                            <span class="skill-tag"><?= htmlspecialchars($job['job_location_district']) ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        // Kiểm tra trạng thái đã lưu khi tải trang
        <?php if ($is_logged_in): ?>
            $.get('check_saved_job.php', { job_id: <?= $job_detail_id ?> }, function (data) {
                if (data === 'saved') {
                    $('#save-job-btn').removeClass('btn-secondary').addClass('btn-danger');
                    $('#save-job-icon').html('&#9733;');
                } else {
                    $('#save-job-btn').removeClass('btn-danger').addClass('btn-secondary');
                    $('#save-job-icon').html('&#9734;');
                }
            });
        <?php endif; ?>

        $('#save-job-btn').on('click', function (e) {
            <?php if (!$is_logged_in): ?>
                // Đã xử lý chuyển hướng bằng thuộc tính onclick trên nút
                return;
            <?php else: ?>
                var btn = $(this);
                var jobId = btn.data('job-id');
                var isSaved = btn.hasClass('btn-danger');
                $.ajax({
                    url: 'toggle_save_job.php',
                    type: 'POST',
                    data: { job_id: jobId, action: isSaved ? 'unsave' : 'save' },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'saved') {
                            btn.removeClass('btn-secondary').addClass('btn-danger');
                            $('#save-job-icon').html('&#9733;');
                            showToast('Job saved successfully');
                        } else if (response.status === 'unsaved') {
                            btn.removeClass('btn-danger').addClass('btn-secondary');
                            $('#save-job-icon').html('&#9734;');
                            showToast('Job unsaved successfully');
                        }
                    }
                });
            <?php endif; ?>
        });

        function showToast(message) {
            var toast = $(
                '<div class="toast align-items-center text-bg-primary border-0 position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" style="z-index:9999;">' +
                    '<div class="d-flex">' +
                        '<div class="toast-body">' + message + '</div>' +
                        '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
                    '</div>' +
                '</div>'
            );
            $('body').append(toast);
            var bsToast = new bootstrap.Toast(toast[0]);
            bsToast.show();
            toast.on('hidden.bs.toast', function () { toast.remove(); });
        }
    });
    </script>

</body>


<footer>
    <?php require_once 'homepage/footer.php' ?>
</footer>

</html>