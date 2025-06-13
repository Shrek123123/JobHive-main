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
if (!$countRes) {
  die("Lỗi truy vấn đếm job: " . $conn->error);
}
$totalItems = $countRes->fetch_assoc()['count'];
// Tính tổng số trang
$totalPages = (int) ceil($totalItems / $itemsPerPage);

// Truy vấn chính với LIMIT + OFFSET tới cơ sở dữ liệu
$offset = ($page - 1) * $itemsPerPage;
$sql = "SELECT id, job_title, company_name, salary, job_location, created_at"
  . " FROM job";
if (CURRENT_CATEGORY !== '') {
  $sql .= " WHERE category = '$safeCat'";
}
$sql .= " ORDER BY created_at DESC"
  . " LIMIT $offset, $itemsPerPage";
$result = $conn->query($sql);
if (!$result) {
  die("Lỗi truy vấn danh sách job: " . $conn->error);
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <!-- <job_title>JobHive - Trang Chủ</job_title> -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      color: #000;
    }

    .job-card {
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .filter-btn {
      margin: 0 8px 8px 0;
    }

    ul.pagination {
      list-style: none;
      padding-left: 0;
    }

    .search-box input,
    .search-box select {
      padding: 10px;
      border-radius: 8px;
      border: none;
      min-width: 220px;
    }

    .search-box button {
      background-color: #c4002f;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    .main-content {
      display: flex;
      margin-top: 30px;
      gap: 20px;
      flex-wrap: wrap;
    }

    .left-menu {
      flex: 1;
      min-width: 200px;
      background: white;
      color: black;
      border-radius: 10px;
      padding: 20px;
    }

    .left-menu ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .left-menu li {
      padding: 10px 0;
      border-bottom: 1px solid #eee;
      cursor: pointer;
    }

    .right-banner {
      flex: 3;
      min-width: 300px;
    }

    .right-banner img {
      width: 100%;
      border-radius: 10px;
    }

    .job-section {
      padding: 40px 20px;
      border-radius: 10px;
      background-color: #eee;
      margin: 10px;
    }



    .job-filters {
      margin: 20px 0;
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .job-filters button {
      padding: 8px 15px;
      border: none;
      border-radius: 20px;
      background-color: #eee;
      color: #333;
      cursor: pointer;
    }

    .job-filters button.active {
      background-color: #d70018;
      color: white;
      font-weight: bold;
    }

    .sort-dropdown button {
      background-color: #e0e0e0;
      border: none;
      border-radius: 8px;
      padding: 8px 12px;
      cursor: pointer;
    }

    .section-2 {
      background-color: #eee;
    }


    .circle-logo {
      background-color: #888;
      color: white;
      border-radius: 50%;
      width: 32px;
      height: 32px;
      text-align: center;
      line-height: 32px;
      font-weight: bold;
    }



    .pagination {
      margin-top: 30px;
      text-align: center;
    }

    .pagination .dot {
      height: 10px;
      width: 10px;
      margin: 0 4px;
      background-color: #ccc;
      border-radius: 50%;
      display: inline-block;
    }

    .pagination .dot.active {
      background-color: #d70018;
    }

    .section-3 {
      background-color: #eee;

    }

    .section-3 .container {
      max-width: 1100px;
      margin: 0 auto;
      padding: 20px;
    }

    .section-3 .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .section-3 h2 {
      font-size: 24px;
      font-weight: bold;
      color: #000;
    }

    .section-3 .view-all {
      color: #c00;
      text-decoration: none;
      font-weight: bold;
    }

    .logos {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 20px 0;
      gap: 20px;
    }

    .logos img {
      max-height: 60px;
      object-fit: contain;
    }

    .section-4 {
      background-color: #f9f5f5;

    }

    .section-4 h3 {
      font-size: 20px;
      font-weight: bold;
      margin-top: 30px;
    }

    .section-4 ul {
      list-style: disc;
      margin-left: 20px;
    }

    .info {
      background-color: #f9f5f5;

    }

    .job-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      max-width: 1300px;
      margin: 0 auto;

    }

    .job-card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 15px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .job-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .job-header h3 {
      font-size: 16px;
      margin: 0;
    }

    .save-btn {
      background: none;
      border: none;
      font-size: 20px;
      color: #e74c3c;
      cursor: pointer;
    }

    .job-body {
      display: flex;
      gap: 10px;
      align-items: center;
      margin-top: 10px;
    }

    .company-logo {
      width: 50px;
      height: 50px;
      object-fit: contain;
      border-radius: 5px;
    }

    .job-info {
      font-size: 14px;
    }

    .job-info .company-name {
      font-weight: bold;
      margin-bottom: 5px;
    }

    .icon {
      margin-right: 5px;
    }

    .divider {
      border-top: 1px solid #e0e0e0;
      margin: 10px 0;
    }

    .job-footer {
      font-size: 13px;
      color: #999;
      text-align: right;
    }

    @media (max-width: 992px) {
      .job-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 600px) {
      .job-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

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

  <!-- job_location -->
  <input type="text" name="job_location" placeholder="Địa điểm">
  <button type="submit"><a href="index.php?action=quickSearch">🔍 Tìm nhanh</a></button>
</form>
<!--     
      <button>🔍 Tìm kiếm việc làm</button>

      <div class="search-box">
        <select>
          <option>Danh mục nghề</option>
          <option>IT & Software</option>
          <option>Marketing</option>
          <option>Finance</option>
          <option>Healthcare</option>
          <option>Government</option>
        </select>
        <input type="text" placeholder="Vị trí tuyển dụng, tên công ty">
        <input type="text" placeholder="Địa điểm">
        <button>Tìm kiếm</button> -->

<!-- <div class="search-box">
      <select>
        <option>Danh mục nghề</option>
        <option>IT & Software</option>
        <option>Marketing</option>
        <option>Finance</option>
        <option>Healthcare</option>
        <option>Government & Public Sector</option>
      </select>
      <input type="text" placeholder="Vị trí tuyển dụng, tên công ty">
      <input type="text" placeholder="Địa điểm">
      <button>Tìm kiếm</button> -->
</div>
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
        <h2>🔥 Urgent Job Openings</h2>
        <div class="sort-dropdown">
          <button>Sort by ▾</button>
        </div>
      </div>

      <!-- job-filters: động, dẫn lại homepage với action filterCategory và anchor -->
      <div class="job-filters">
        <?php foreach (CATEGORIES as $code => $label):
          $activeClass = ($code === CURRENT_CATEGORY) ? 'active' : '';
          $url = 'index.php?action=' . ACTION_FILTER . '&category=' . urlencode($code) . '#job-section';
        ?>
          <button class="<?php echo $activeClass; ?>" onclick="window.job_location.href='<?php echo $url; ?>'">
            <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
          </button>
        <?php endforeach; ?>
      </div>

      <div class="job-listings">
        <?php while ($job = $result->fetch_assoc()): ?>
          <div class="job-card">
            <div class="job-header">
              <h4><?php echo htmlspecialchars($job['job_title'], ENT_QUOTES, 'UTF-8'); ?></h4>
              <img src="image/default.png" alt="Logo công ty">
            </div>
            <p class="company">
              <a href="jobdetailpage.php?id=<?php echo $job['id']; ?>">
                <?php echo htmlspecialchars($job['company_name'], ENT_QUOTES, 'UTF-8'); ?>
              </a>
            </p>
            <p class="salary">💰 <?php echo $job['salary']; ?> USD</p>
            <p class="job_location">📍 <?php echo htmlspecialchars($job['job_location'], ENT_QUOTES, 'UTF-8'); ?></p>
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
                  href="index.php?action=<?php echo ACTION_FILTER; ?>&category=<?php echo urlencode(CURRENT_CATEGORY); ?>&page=<?php echo $page - 1; ?>#job-section">
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
                  href="index.php?action=<?php echo ACTION_FILTER; ?>&category=<?php echo urlencode(CURRENT_CATEGORY); ?>&page=<?php echo $page + 1; ?>#job-section">
                  Next &rsaquo;
                </a>
              </li>
            <?php else: ?>
              <li class="page-item disabled"><span class="page-link">Next &rsaquo;</span></li>
            <?php endif; ?>
          </ul>
        </nav>
      <?php endif; ?>
      <!-- Tìm công việc gần nhất -->
      <div class="job-grid">
        <!-- 1 -->
        <?php
        // Lấy 9 job mới nhất
        $sql = "SELECT id, job_title, company_logo, company_name, salary, job_location, created_at, post_duration 
      FROM job 
      LIMIT 9";
        $result = $conn->query($sql);
        if (!$result) {
          die("Lỗi truy vấn danh sách job: " . $conn->error);
        }

        //
        if ($result && $result->num_rows > 0):
          while ($row = $result->fetch_assoc()):
            // Tính days_left
            $created_at = new DateTime($row['created_at']);
            $post_duration = (int) $row['post_duration'];
            $expire_at = clone $created_at;
            $expire_at->modify("+$post_duration days");
            $now = new DateTime();
            $interval = $now->diff($expire_at);
            $days_left = (int) $interval->format('%r%a');
            $days_left_text = $days_left > 0 ? $days_left . ' days left' : 'Expired';
            $job_id = (int)$row['id'];
        ?>
            <a href="jobdetail.php?id=<?php echo $job_id; ?>" style="text-decoration:none;color:inherit;">
              <div class="job-card">
                <div class="job-header">
                  <h3><?php echo htmlspecialchars($row['job_title']); ?></h3>
                  <button class="save-btn">♥</button>
                </div>
                <div class="job-body">
                  <img src="<?php echo htmlspecialchars($row['company_logo']); ?>" alt="Company Logo" class="company-logo">
                  <div class="job-info">
                    <div class="company-name"><?php echo htmlspecialchars($row['company_name']); ?></div>
                    <div><span class="icon">💰</span> <?php echo htmlspecialchars($row['salary']); ?></div>
                    <div><span class="icon">📍</span> <?php echo htmlspecialchars($row['job_location']); ?></div>
                  </div>
                </div>
                <div class="divider"></div>
                <div class="job-footer">
                  <div class="deadline"><?php echo $days_left_text; ?></div>
                </div>
              </div>
            </a>
          <?php
          endwhile;
        else:
          ?>
          <div>No jobs found.</div>
        <?php endif; ?>
        <!-- 2 -->
        <!-- 3 -->
        <!-- Lặp lại 8 lần nữa cho đủ 9 thẻ -->
      </div>
  </section>

  <section class="section-3">
    <div class="container">
      <div class="header">
        <h2>🌟 Công Ty Nổi Bật</h2>
        <a href="#" class="view-all">Xem tất cả →</a>
      </div>
      <div class="logos">
        <img src="image/logo1.jpg" alt="ABC Corp" />
        <img src="image/logo2.jpg" alt="XYZ Ltd" />
        <img src="image/logo3.jpg" alt="Tech Solutions" />
        <img src="image/logo4.jpg" alt="NextGen Co" />
        <img src="image/logo5.jpg" alt="Creative Minds" />
      </div>
    </div>
  </section>

  <section class="section-4">
    <div class="container">
      <h3>Opportunities to apply for attractive jobs at top companies</h3>
      <p>With the rapid development of the economy... professional environment.</p>

      <h3>Why should you look for jobs at JobHive?</h3>
      <ul>
        <li><strong>Việc làm Chất lượng</strong><br />Hàng ngàn tin tuyển dụng chất lượng... CV của bạn.</li>
        <li><strong>Công cụ viết CV đẹp Miễn phí</strong><br />Nhiều mẫu CV đẹp... trong vòng 5 phút.</li>
        <!-- <li><strong>Hỗ trợ Người tìm việc</strong><br />Nhà tuyển dụng... xem CV và gửi lời mời.</li>
        <li><strong>Quality Jobs</strong><br />
          Thousands of high-quality job postings... to your CV.</li>
        <li><strong>Free Beautiful CV Builder</strong><br />
          Many beautiful CV templates... in just 5 minutes.</li>
        <li><strong>Job Seeker Support</strong><br />
          Employers... view your CV and send invitations.</li> -->
      </ul>
      <p>At JobHive, you can find... the best salary!</p>
    </div>
  </section>
</div>