<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helper.php';

// Định nghĩa các action
define('ACTION_SEARCH', 'quickResults');   // cho form tìm kiếm
define('ACTION_FILTER', 'filterCategory'); // cho filter category

// Lấy category đang chọn
define('CURRENT_CATEGORY', isset($_GET['category']) ? $_GET['category'] : '');

// Danh sách category (code => label)
define('CATEGORIES', [
    ''           => 'Tất cả',
    'IT'         => 'IT & Software',
    'Marketing'  => 'Marketing',
    'Finance'    => 'Finance',
    'Healthcare' => 'Healthcare',
    'Government' => 'Government & Public Sector'
]);
// 1. Thiết lập pagination
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$itemsPerPage = 5;

// Đếm tổng jobs với filter (nếu có)
$countSql = "SELECT COUNT(*) AS count FROM job";
if (CURRENT_CATEGORY !== '') {
    $safeCat = $conn->real_escape_string(CURRENT_CATEGORY);
    $countSql .= " WHERE category = '$safeCat'";
}
$countRes = $conn->query($countSql);
$totalItems = $countRes->fetch_assoc()['count'];

// Tính tổng số trang
$totalPages = (int) ceil($totalItems / $itemsPerPage);

// Truy vấn chính với LIMIT + OFFSET tới cơ sở dữ liệu
$offset = ($page - 1) * $itemsPerPage;
$sql = "SELECT id, title, company_name, salary, location, created_at"
     . " FROM job";
if (CURRENT_CATEGORY !== '') {
    $sql .= " WHERE category = '$safeCat'";
}
$sql .= " ORDER BY created_at DESC"
     . " LIMIT $offset, $itemsPerPage";
$result = $conn->query($sql);
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>JobHive - Trang Chủ</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    .job-card { border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .filter-btn { margin: 0 8px 8px 0; }
    ul.pagination {
      list-style: none;
      padding-left: 0;
    }
</style>
</head>
<section class="section-1">
  <div class="container">
    <div class="title">Tìm việc làm nhanh 24h, việc làm mới nhất trên toàn quốc.</div>
    <div class="subtitle">Tiếp cận 40,000+ tin tuyển dụng việc làm mới mỗi ngày từ hàng nghìn doanh nghiệp uy tín tại Việt Nam</div>

    <form class="search-box" method="GET" action="index.php">
      <input type="hidden" name="action" value="<?php echo ACTION_SEARCH; ?>">
      <!-- Category tìm kiếm chung -->
      <select name="category">
        <option value="">-- Danh mục nghề --</option>
        <?php foreach (CATEGORIES as $code => $label): ?>
          <option value="<?php echo $code; ?>" <?php echo ($code === CURRENT_CATEGORY ? 'selected' : ''); ?>>
            <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
          </option>
        <?php endforeach; ?>
      </select>

      <!-- Job Type -->
      <select name="job_type">
        <option value="">-- Job Type --</option>
        <option value="full-time">Full-time</option>
        <option value="part-time">Part-time</option>
        <option value="internship">Internship</option>
        <option value="contract">Contract</option>
      </select>

      <!-- Location -->
      <input type="text" name="location" placeholder="Địa điểm">
      <button type="submit">🔍 Tìm nhanh</button>
    </form>

    <div class="main-content">
      <div class="left-menu">
        <ul>
          <li>IT & Software</li>
          <li>Marketing</li>
          <li>Finance</li>
          <li>Healthcare</li>
          <li>Government & Public Sector</li>
        </ul>
      </div>
      <div class="right-banner">
        <img src="image/jobhive.png" alt="Tuyển dụng">
      </div>
    </div>
  </div>
</section>

<div class="info">
  <!-- Thêm id để anchor -->
  <section id="job-section" class="section-2">
    <div class="job-section">
      <div class="job-header">
        <h2>🔥 Việc làm tuyển gấp</h2>
        <div class="sort-dropdown">
          <button>Sắp xếp theo ▾</button>
        </div>
      </div>

      <!-- job-filters: động, dẫn lại homepage với action filterCategory và anchor -->
      <div class="job-filters">
        <?php foreach (CATEGORIES as $code => $label):
            $activeClass = ($code === CURRENT_CATEGORY) ? 'active' : '';
            $url = 'index.php?action=' . ACTION_FILTER . '&category=' . urlencode($code). '#job-section';
        ?>
          <button class="<?php echo $activeClass; ?>" onclick="window.location.href='<?php echo $url; ?>'">
            <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
          </button>
        <?php endforeach; ?>
      </div>

      <div class="job-listings">
  <?php while ($job = $result->fetch_assoc()): ?>
    <div class="job-card">
      <div class="job-header">
        <h4><?php echo htmlspecialchars($job['title'], ENT_QUOTES, 'UTF-8'); ?></h4>
        <img src="image/default.png" alt="Logo công ty">
      </div>
      <p class="company">
        <a href="jobdetailpage.php?id=<?php echo $job['id']; ?>">
          <?php echo htmlspecialchars($job['company_name'], ENT_QUOTES, 'UTF-8'); ?>
        </a>
      </p>
      <p class="salary">💰 <?php echo number_format($job['salary']); ?> USD</p>
      <p class="location">📍 <?php echo htmlspecialchars($job['location'], ENT_QUOTES, 'UTF-8'); ?></p>
      <p class="posted">🕒 <?php echo date('d/m/Y', strtotime($job['created_at'])); ?></p>
      <a href="jobdetailpage.php?id=<?php echo $job['id']; ?>"
         class="btn btn-danger mt-2">
        Chi tiết công việc
      </a>
    </div>
  <?php endwhile; ?>
</div>

      <?php if ($totalPages > 1): ?>
  <nav aria-label="Trang" class="mt-4">
    <ul class="pagination justify-content-center">
      <!-- Prev -->
      <?php if ($page > 1): ?>
        <li class="page-item">
          <a class="page-link"
             href="index.php?action=<?php echo ACTION_FILTER; ?>&category=<?php echo urlencode(CURRENT_CATEGORY); ?>&page=<?php echo $page-1; ?>#job-section">
            &lsaquo; Prev
          </a>
        </li>
      <?php else: ?>
        <li class="page-item disabled"><span class="page-link">&lsaquo; Prev</span></li>
      <?php endif; ?>

      <!-- Các số trang -->
      <?php
        $start = max(1, $page - 2);
        $end   = min($totalPages, $page + 2);
        for ($i = $start; $i <= $end; $i++):
          $url = "index.php?action=" . ACTION_FILTER
               . "&category=" . urlencode(CURRENT_CATEGORY)
               . "&page=$i#job-section";
      ?>
        <?php if ($i === $page): ?>
          <li class="page-item active"><span class="page-link"><?php echo $i; ?></span></li>
        <?php else: ?>
          <li class="page-item"><a class="page-link" href="<?php echo $url; ?>"><?php echo $i; ?></a></li>
        <?php endif; ?>
      <?php endfor; ?>

      <!-- Next -->
      <?php if ($page < $totalPages): ?>
        <li class="page-item">
          <a class="page-link"
             href="index.php?action=<?php echo ACTION_FILTER; ?>&category=<?php echo urlencode(CURRENT_CATEGORY); ?>&page=<?php echo $page+1; ?>#job-section">
            Next &rsaquo;
          </a>
        </li>
      <?php else: ?>
        <li class="page-item disabled"><span class="page-link">Next &rsaquo;</span></li>
      <?php endif; ?>
    </ul>
  </nav>
<?php endif; ?>

    </div>
  </section>

  <section class="section-3">
    <div class="container">
      <div class="header">
        <h2>🌟 Công Ty Nổi Bật</h2>
        <a href="#" class="view-all">Xem tất cả →</a>
      </div>
      <div class="logos">
        <img src="image/logo1.png" alt="Tabtab.me" />
        <img src="image/logo2.png" alt="DIC" />
        <img src="image/logo3.png" alt="NhanHoa" />
        <img src="image/logo4.png" alt="EY" />
        <img src="image/logo5.png" alt="Karofi" />
      </div>
    </div>
  </section>

  <section class="section-4">
    <div class="container">
      <h3>Cơ hội ứng tuyển việc làm với đãi ngộ hấp dẫn tại các công ty hàng đầu</h3>
      <p>Trước sự phát triển vượt bậc của nền kinh tế... chuyên nghiệp.</p>

      <h3>Vậy tại sao nên tìm việc làm tại JobHive?</h3>
      <ul>
        <li><strong>Việc làm Chất lượng</strong><br />Hàng ngàn tin tuyển dụng chất lượng... CV của bạn.</li>
        <li><strong>Công cụ viết CV đẹp Miễn phí</strong><br />Nhiều mẫu CV đẹp... trong vòng 5 phút.</li>
        <li><strong>Hỗ trợ Người tìm việc</strong><br />Nhà tuyển dụng... xem CV và gửi lời mời.</li>
      </ul>

      <p>Tại JobHive, bạn có thể tìm thấy... mức lương tốt nhất!</p>
    </div>
  </section>
</div>
