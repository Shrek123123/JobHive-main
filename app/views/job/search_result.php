<?php
// Nhận các biến từ controller:
// $jobs (mảng job trang hiện tại),
// $totalItems (tổng số job),
// $page (trang hiện tại),
// $totalPages (tổng số trang),
// $keyword, $job_location, $job_category, $job_type (filter)

?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <job_title>Kết quả tìm kiếm việc làm</job_title>
  <!-- 1. Thêm Bootstrap CSS và Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    /* 2. Tinh chỉnh card */
    .job-card {
      border: none;
      border-radius: .75rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .job-logo {
      max-height: 60px;
      object-fit: contain;
    }

    .pagination .active span {
      background-color: #007bff;
      color: #fff;
      border-color: #007bff;
    }

    .pagination .disabled span {
      color: #999;
      border-color: #ddd;
    }

    .job-tabs a.active {
      background-color: #007bff;
      color: #fff !important;
      border-color: #007bff;
    }
  </style>
</head>

<body>
  <div class="container py-4">
    <h1 class="mb-4">Kết quả tìm kiếm</h1>

    <!-- 3. Tabs chọn job_category -->
    <?php
    $tabs = [
      'Tất cả'                    => '',
      'IT & Software'             => 'IT & Software',
      'Marketing'                 => 'Marketing',
      'Finance'                   => 'Finance',
      'Healthcare'                => 'Healthcare',
      'Government & Public Sector' => 'Government & Public Sector'
    ];
    $currentCat = $_GET['job_category'] ?? '';

    $baseParams = [
      'action'   => $_GET['action']   ?? 'searchResults',
      'keyword'  => $_GET['keyword']  ?? '',
      'job_location' => $_GET['job_location'] ?? '',
      'job_category' => $currentCat,
      'job_type' => $_GET['job_type'] ?? ''
    ];
    function buildUrl(array $params): string
    {
      return '?' . http_build_query($params);
    }
    ?>
    <nav class="mb-4">
      <div class="nav nav-pills">
        <?php foreach ($tabs as $label => $val):
          $params = $baseParams;
          $params['job_category'] = $val;
          $params['page'] = 1;
          $url = buildUrl($params);
          $active = ($val === $currentCat) ? 'active' : '';
        ?>
          <a href="<?= $url ?>" class="nav-link <?= $active ?>"><?= $label ?></a>
        <?php endforeach; ?>
      </div>
    </nav>

    <?php if (!empty($jobs)): ?>

      <!-- 4. Grid cards hiển thị job -->
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-4">
        <?php foreach ($jobs as $job): ?>
          <div class="col">
            <div class="card job-card h-100">
              <!-- Logo (Nếu muốn bỏ, xóa block này) -->
              <?php if (!empty($job['company_logo'])): ?>
                <img src="/uploads/logos/<?= htmlspecialchars($job['company_logo']) ?>"
                  class="card-img-top job-logo p-3"
                  alt="Logo <?= htmlspecialchars($job['company_name']) ?>">
              <?php endif; ?>

              <div class="card-body d-flex flex-column">
                <h5 class="card-job_title"><?= htmlspecialchars($job['job_title'], ENT_QUOTES, 'UTF-8') ?></h5>
                <p class="mb-1">
                  <a href="#" class="text-decoration-none">
                    <?= htmlspecialchars($job['company_name'], ENT_QUOTES, 'UTF-8') ?>
                  </a>
                </p>
                <p class="mb-1 text-danger fw-bold">
                  <i class="bi bi-currency-dollar me-1"></i>
                  <?= htmlspecialchars($job['salary'], ENT_QUOTES, 'UTF-8') ?>
                </p>
                <p class="mb-1 text-muted">
                  <i class="bi bi-geo-alt me-1"></i>
                  <?= htmlspecialchars($job['job_location'], ENT_QUOTES, 'UTF-8') ?>
                </p>
                <p class="mb-3 text-muted small">
                  <i class="bi bi-calendar-event me-1"></i>
                  <?= date('d/m/Y', strtotime($job['posted_date'] ?? $job['created_at'])) ?>
                </p>

                <!-- Nút Chi tiết công việc -->
                <div class="mt-auto">
                  <a href="jobdetailpage.php?id=<?= (int)$job['id'] ?>"
                    class="btn btn-outline-primary btn-sm w-100">
                    Chi tiết công việc
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- 5. Pagination -->
      <?php if ($totalPages > 1): ?>
        <nav aria-label="Trang">
          <ul class="pagination justify-content-center">
            <!-- Prev -->
            <?php if ($page > 1):
              $prev = $baseParams;
              $prev['page'] = $page - 1;
            ?>
              <li class="page-item">
                <a class="page-link" href="<?= buildUrl($prev) ?>">&lsaquo; Prev</a>
              </li>
            <?php else: ?>
              <li class="page-item disabled"><span class="page-link">&lsaquo; Prev</span></li>
            <?php endif; ?>

            <!-- Số trang -->
            <?php
            $start = max(1, $page - 2);
            $end   = min($totalPages, $page + 2);
            for ($i = $start; $i <= $end; $i++):
              if ($i === $page): ?>
                <li class="page-item active"><span class="page-link"><?= $i ?></span></li>
              <?php else:
                $p = $baseParams;
                $p['page'] = $i;
              ?>
                <li class="page-item">
                  <a class="page-link" href="<?= buildUrl($p) ?>"><?= $i ?></a>
                </li>
            <?php endif;
            endfor;
            ?>

            <!-- Next -->
            <?php if ($page < $totalPages):
              $next = $baseParams;
              $next['page'] = $page + 1;
            ?>
              <li class="page-item">
                <a class="page-link" href="<?= buildUrl($next) ?>">Next &rsaquo;</a>
              </li>
            <?php else: ?>
              <li class="page-item disabled"><span class="page-link">Next &rsaquo;</span></li>
            <?php endif; ?>
          </ul>
        </nav>
      <?php endif; ?>

    <?php else: ?>
      <p class="text-center text-muted">Không tìm thấy công việc nào phù hợp với tiêu chí bạn đã nhập.</p>
    <?php endif; ?>

    <p class="mt-4">
      <a href="index.php?action=home" class="text-decoration-none">&larr; Quay lại trang chủ</a>
    </p>
  </div>

  <!-- 6. Thêm JS của Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>