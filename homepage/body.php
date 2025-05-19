<section class="section-1">
  <div class="container">
    <div class="title">Tìm việc làm nhanh 24h, việc làm mới nhất trên toàn quốc.</div>
    <div class="subtitle">Tiếp cận 40,000+ tin tuyển dụng việc làm mới mỗi ngày từ hàng nghìn doanh nghiệp uy tín tại Việt Nam</div>

    <form class="search-box" method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?action=quickResults">
      <!-- Category -->
      <select name="category">
        <option value="">-- Danh mục nghề --</option>
        <option value="IT">IT & Software</option>
        <option value="Marketing">Marketing</option>
        <option value="Finance">Finance</option>
        <option value="Healthcare">Healthcare</option>
        <option value="Government">Government & Public Sector</option>
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

      <div class="job-listings">
        <?php
        include_once 'config.php';
        $sql = "SELECT id, title, company_name, salary, location, created_at FROM job ORDER BY created_at DESC LIMIT 6";
        $result = $conn->query($sql);

        while ($job = $result->fetch_assoc()):
        ?>
          <div class="job-card">
            <div class="job-header">
              <h4><?= htmlspecialchars($job['title']) ?></h4>
              <img src="image/default.png" alt="Logo công ty">
            </div>
            <p class="company"><a href="jobdetailpage.php?id=<?= $job['id'] ?>"><?= htmlspecialchars($job['company_name']) ?></a></p>
            <p class="salary">💰 <?= number_format($job['salary']) ?> USD</p>
            <p class="location">📍 <?= htmlspecialchars($job['location']) ?></p>
            <p class="posted">🕒 <?= date('d/m/Y', strtotime($job['created_at'])) ?></p>
            <a href="jobdetailpage.php?id=<?= $job['id'] ?>" class="btn btn-danger mt-2">Chi tiết công việc</a>
          </div>
        <?php endwhile; ?>
      </div>

      <div class="pagination">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
      </div>
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
