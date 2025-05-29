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
    //Đổi màu nút Save job
    // Lấy jobId từ thuộc tính data-job-id của nút Save job
    document.addEventListener('DOMContentLoaded', function () {
        const saveBtn = document.getElementById('save-job-btn');
        if (!saveBtn) return;
        const jobId = saveBtn.getAttribute('data-job-id');
        const savedJobs = JSON.parse(localStorage.getItem('savedJobs') || '[]');
        if (savedJobs.includes(jobId)) {
            document.getElementById('save-job-icon').innerHTML = '★';
            saveBtn.classList.add('btn-danger');
            saveBtn.classList.remove('btn-secondary');
        }

        // Hiển thị thông báo
        function showToast(message) {
            let toast = document.createElement('div');
            toast.innerText = message;
            toast.style.position = 'fixed';
            toast.style.bottom = '30px';
            toast.style.right = '30px';
            toast.style.background = '#333';
            toast.style.color = '#fff';
            toast.style.padding = '12px 24px';
            toast.style.borderRadius = '6px';
            toast.style.zIndex = 9999;
            toast.style.boxShadow = '0 2px 8px rgba(0,0,0,0.2)';
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => document.body.removeChild(toast), 400);
            }, 1500);
        }

        saveBtn.addEventListener('click', function (e) {
            // Nếu nút có thuộc tính onclick (tức là chưa đăng nhập), không xử lý lưu job
            if (saveBtn.hasAttribute('onclick')) {
                return;
            }
            e.preventDefault();
            let savedJobs = JSON.parse(localStorage.getItem('savedJobs') || '[]');
            const icon = document.getElementById('save-job-icon');
            if (savedJobs.includes(jobId)) {
                savedJobs = savedJobs.filter(id => id !== jobId);
                icon.innerHTML = '☆';
                this.classList.remove('btn-danger');
                this.classList.add('btn-secondary');
                showToast('Job unsaved successfully!');
            } else {
                savedJobs.push(jobId);
                icon.innerHTML = '★';
                this.classList.add('btn-danger');
                this.classList.remove('btn-secondary');
                showToast('Job saved successfully!');
            }
            localStorage.setItem('savedJobs', JSON.stringify(savedJobs));
        });
    });
</script>
<?php
// Xử lý AJAX tăng/giảm interest_count khi lưu/huỷ lưu job
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['job_id'])) {
    session_start();
    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'jobseeker') {
        http_response_code(403);
        exit('Unauthorized');
    }
    require_once 'config.php';
    $job_id = intval($_POST['job_id']);
    $action = $_POST['action'];

    if ($job_id > 0 && in_array($action, ['save', 'unsave'])) {
        // Kiểm tra xem đã có dòng cho job_id này chưa
        $stmt = $conn->prepare("SELECT interest_count FROM job_interest_count WHERE job_id = ?");
        $stmt->bind_param("i", $job_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            // Đã có, cập nhật
            if ($action === 'save') {
                $stmt2 = $conn->prepare("UPDATE job_interest_count SET interest_count = GREATEST(interest_count - 1, 0) WHERE job_id = ?");
                $stmt2->bind_param("i", $job_id);
                $stmt2->execute();
                $stmt2->close();
            } elseif ($action === 'unsave') {
                $stmt2 = $conn->prepare("UPDATE job_interest_count SET interest_count = interest_count + 1 WHERE job_id = ?");
                $stmt2->bind_param("i", $job_id);
                $stmt2->execute();
                $stmt2->close();
            }
        } else {
            // Chưa có, thêm mới nếu là unsave
            if ($action === 'unsave') {
                $stmt2 = $conn->prepare("INSERT INTO job_interest_count (job_id, interest_count) VALUES (?, 1)");
                $stmt2->bind_param("i", $job_id);
                $stmt2->execute();
                $stmt2->close();
            }
        }
        $stmt->close();
        echo 'success';
        exit;
    }
    http_response_code(400);
    exit('Invalid request');
}
?>

<script>
//Ngăn ko đổi màu nút Save job khi chưa đăng nhập
document.addEventListener('DOMContentLoaded', function () {
    const saveBtn = document.getElementById('save-job-btn');
    if (!saveBtn) return;
    const jobId = saveBtn.getAttribute('data-job-id');
    // Đã có xử lý localStorage ở trên, chỉ cần thêm AJAX gọi PHP khi đã đăng nhập
    saveBtn.addEventListener('click', function (e) {
        if (saveBtn.hasAttribute('onclick')) return; // chưa đăng nhập
        // Xác định action
        let savedJobs = JSON.parse(localStorage.getItem('savedJobs') || '[]');
        let action = savedJobs.includes(jobId) ? 'unsave' : 'save';
        // Gửi AJAX tới PHP
        fetch(window.location.pathname, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'action=' + encodeURIComponent(action) + '&job_id=' + encodeURIComponent(jobId)
        })
        .then(res => res.text())
        .then(data => {
            // Không cần xử lý gì thêm, localStorage và giao diện đã xử lý ở trên
        });
    });
});
</script>
</body>


<footer>
    <?php require_once 'homepage/footer.php' ?>`
</footer>

</html>