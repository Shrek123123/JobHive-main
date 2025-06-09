<?php
// file: homepage/jobdetailpage.php

include_once __DIR__ . '/config.php';    // tạo $conn
include_once __DIR__ . '/helper.php'; // gọi các hàm đã xử dụng
// 1. Lấy ID từ URL
if (!isset($_GET['id'])) {
    exit('<p class="text-danger">Thiếu ID công việc.</p>');
}
$jobId = (int) $_GET['id'];

// 2. Lấy thông tin job
$stmt = $conn->prepare("SELECT * FROM job WHERE id = ?");
$stmt->bind_param("i", $jobId);
$stmt->execute();
$job = $stmt->get_result()->fetch_assoc();
if (!$job) {
    exit('<p class="text-danger">Không tìm thấy công việc.</p>');
}

// 3. Lấy skills của job
$stmt2 = $conn->prepare("
  SELECT s.name
  FROM skill s
  JOIN job_skill js ON s.id = js.skill_id
  WHERE js.job_id = ?
");
$stmt2->bind_param("i", $jobId);
$stmt2->execute();
$res2 = $stmt2->get_result();
$skills = [];
while ($r = $res2->fetch_assoc()) {
    $skills[] = $r['name'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Chi tiết tuyển dụng – <?= htmlspecialchars($job['job_title']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <style>
    body { background-color: #f8f9fa; }
    .skill-tag {
      display: inline-block;
      background: #e0f3ff;
      color: #007bff;
      padding: 4px 8px;
      margin: 2px 2px 2px 0;
      border-radius: 4px;
      font-size: 13px;
    }
    .sidebar-title { font-weight: bold; margin-bottom: 10px; }
  </style>
  <script>
    $(function(){
      $('.apply-btn').on('click',function(){
        $('#applyModal').modal('show');
        $('#applyFormContent').load('applyform.php');
      });
    });
  </script>
</head>
<body>
  <header class="bg-danger text-white py-3">
    <div class="container">
      <?php require_once __DIR__ . '/homepage/header.php' ?>
    </div>
  </header>

  <div class="container my-5">
    <div class="row">
      <!-- Left Column: Job Detail -->
      <div class="col-lg-8 mb-4">
        <div class="bg-white p-4 shadow rounded">
          <!-- Logo công ty nếu có -->
          <?php if (!empty($job['company_logo'])): ?>
            <img src="/uploads/logos/<?= htmlspecialchars($job['company_logo']) ?>"
                 alt="Logo <?= htmlspecialchars($job['company_name']) ?>"
                 class="mb-3" style="max-width:100px;">
          <?php endif; ?>

          <!-- Tiêu đề & tổng compensation -->
          <h5 class="fw-bold"><?= htmlspecialchars($job['title']) ?></h5>
          <small class="text-muted">
            (Total Annual Compensation $
            <?= number_format($job['salary_min'], 0) ?> – <?= number_format($job['salary_max'], 0) ?>)
          </small>
          <hr>

          <!-- Các thông tin chính -->
          <div class="row mb-3">
            <div class="col-md-4 d-flex align-items-center">
              <i class="bi bi-currency-dollar me-2"></i>
              <strong>Mức lương</strong>
            </div>
            <div class="col-md-8 text-danger fw-bold">
              <?= convertUsdToVnd(number_format($job['salary_min'], 0)) ?> – <?= convertUsdToVnd(number_format($job['salary_max'], 0)) ?> VND
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4 d-flex align-items-center">
              <i class="bi bi-geo-alt me-2"></i>
              <strong>Địa điểm</strong>
            </div>
            <div class="col-md-8"><?= htmlspecialchars($job['location']) ?></div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4 d-flex align-items-center">
              <i class="bi bi-person-workspace me-2"></i>
              <strong>Kinh nghiệm</strong>
            </div>
            <div class="col-md-8"><?= htmlspecialchars($job['experience_level']) ?></div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4 d-flex align-items-center">
              <i class="bi bi-clock-history me-2"></i>
              <strong>Hình thức</strong>
            </div>
            <div class="col-md-8"><?= htmlspecialchars($job['remote']) ?></div>
          </div>

          <div class="text-muted mb-3">
            <i class="bi bi-calendar-event me-2"></i>
            Hạn nộp hồ sơ:
            <?= date('d/m/Y', strtotime($job['application_deadline'])) ?>
          </div>

          <div class="d-flex gap-3 mb-4">
            <button class="btn btn-danger apply-btn">Ứng tuyển ngay</button>
            <a href="#" class="btn btn-secondary">Lưu tin</a>
          </div>

          <!-- Phần Chi tiết tuyển dụng động -->
          <h2 class="text-danger mt-4">Chi tiết tuyển dụng</h2>
          <p><strong>Chuyên môn:</strong> <?= htmlspecialchars($job['category']) ?></p>
          <p><strong>Ngành:</strong> <?= htmlspecialchars($job['industry']) ?></p>
          <p><strong>Loại công việc:</strong> <?= htmlspecialchars($job['job_type']) ?></p>

          <!-- Mô tả công việc -->
          <h2 class="text-danger mt-4">Mô tả công việc</h2>
          <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>

          <!-- Kỹ năng cần có -->
          <?php if (!empty($skills)): ?>
            <h2 class="text-danger mt-4">Kỹ năng cần có</h2>
            <?php foreach ($skills as $sk): ?>
              <span class="skill-tag"><?= htmlspecialchars($sk) ?></span>
            <?php endforeach; ?>
          <?php endif; ?>

          <!-- Modal Apply -->
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

        <!-- Việc làm liên quan -->
      </div>

      <!-- Right Column: Sidebar thông tin công ty & chung -->
      <div class="col-lg-4">
        <?php if (!empty($job['company_logo'])): ?>
          <div class="bg-white p-3 mb-4 shadow rounded">
            <div class="d-flex align-items-center mb-3">
              <img src="/uploads/logos/<?= htmlspecialchars($job['company_logo']) ?>"
                   alt="Logo công ty" class="me-3 rounded" style="width:80px; height:80px;">
              <div class="sidebar-title mb-0">
                <h4><?= htmlspecialchars($job['company_name']) ?></h4>
                <!-- Nếu có thêm cột company_address, company_size… bạn có thể echo ở đây -->
              </div>
            </div>
          </div>
        <?php endif; ?>

        <div class="bg-white p-3 mb-4 shadow rounded">
          <div class="sidebar-title">Thông tin chung</div>
          <p><strong>Cấp bậc:</strong> <?= htmlspecialchars($job['required_certification']) ?></p>
          <p><strong>Số lượng:</strong> <?= htmlspecialchars($job['vacancies'] ?? '1') ?> người</p>
          <p><strong>Hình thức:</strong> <?= htmlspecialchars($job['job_type']) ?></p>
        </div>

        <div class="bg-white p-3 mb-4 shadow rounded">
          <div class="sidebar-title">Kỹ năng cần có</div>
          <?php foreach ($skills as $sk): ?>
            <span class="skill-tag"><?= htmlspecialchars($sk) ?></span>
          <?php endforeach; ?>
        </div>

        <div class="bg-white p-3 shadow rounded">
          <div class="sidebar-title">Địa điểm</div>
          <span class="skill-tag"><?= htmlspecialchars($job['location']) ?></span>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <?php require_once __DIR__ . '/homepage/footer.php' ?>
  </footer>
</body>
</html>
