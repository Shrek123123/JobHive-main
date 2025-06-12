<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<?php require_once('config.php'); // Bây giờ bạn có thể truy cập các cột như $row['ten_cot'] ?>
<style>
  body {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    color: #000;
  }

  .section-1 {
    background: linear-gradient(to right, #c31432, #240b36);
  }

  .container {
    max-width: 1100px;
    margin: auto;
    padding: 40px 20px;
  }

  .title {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
  }

  .subtitle {
    text-align: center;
    margin-top: 5px;
    font-size: 14px;
    color: #ddd;
  }

  .search-box {
    margin-top: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;

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

<section class="section-1">
  <div class="container">
    <div class="title">Tìm việc làm nhanh 24h, việc làm mới nhất trên toàn quốc.</div>
    <div class="subtitle">Tiếp cận 40,000+ tin tuyển dụng việc làm mới mỗi ngày từ hàng nghìn doanh nghiệp uy tín tại
      Việt Nam</div>

    <!--     
      <a href="index.php?action=search"><button>🔍 Tìm kiếm việc làm</button></a>

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

    <div class="search-box">
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
      <button>Tìm kiếm</button>
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
  <section class="section-2">
    <div class="job-section">
      <div class="job-header">
        <h2>🔥 Việc làm tuyển gấp</h2>
        <div class="sort-dropdown">
          <button>Sắp xếp theo ▾</button>
        </div>
      </div>

      <div class="job-filters">
        <button class="active">Tất cả</button>
        <button>IT & Software</button>
        <button>Marketing</button>
        <button>Finance</button>
        <button>Healthcare</button>
        <button>Government & Public Sector</button>
      </div>

      <div class="job-grid">
        <!-- 1 -->
        <?php
        // Lấy 9 job mới nhất
        $sql = "SELECT id, job_title, company_logo, company_name, salary, job_location, created_at, post_duration 
          FROM job 
          LIMIT 9";
        $result = $conn->query($sql);

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
      <h3>Cơ hội ứng tuyển việc làm với đãi ngộ hấp dẫn tại các công ty hàng đầu</h3>
      <p>Trước sự phát triển vượt bậc của nền kinh tế... chuyên nghiệp.</p>

      <h3>Vậy tại sao nên tìm việc làm tại JobHive?</h3>
      <ul>
        <li><strong>Việc làm Chất lượng</strong><br />
          Hàng ngàn tin tuyển dụng chất lượng... CV của bạn.</li>
        <li><strong>Công cụ viết CV đẹp Miễn phí</strong><br />
          Nhiều mẫu CV đẹp... trong vòng 5 phút.</li>
        <li><strong>Hỗ trợ Người tìm việc</strong><br />
          Nhà tuyển dụng... xem CV và gửi lời mời.</li>
      </ul>

      <p>Tại JobHive, bạn có thể tìm thấy... mức lương tốt nhất!</p>
    </div>
  </section>

</div>