<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<?php
// Đặt ở ĐẦU file jobs.php (hoặc index.php)
require_once('config.php'); // Đảm bảo file này chứa kết nối $conn

$isLoggedIn = isset($_SESSION['jobseeker_id']) && $_SESSION['jobseeker_id'] > 0;
$userId = $isLoggedIn ? (int) $_SESSION['jobseeker_id'] : 0;

// Lấy danh sách job_id mà người dùng hiện tại đã lưu từ database
$savedJobIds = [];
if ($isLoggedIn) {
  $stmt = $conn->prepare("SELECT job_id FROM saved_jobs WHERE user_id = ?");
  if ($stmt) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result_saved_jobs = $stmt->get_result();
    while ($row = $result_saved_jobs->fetch_assoc()) {
      $savedJobIds[] = (string) $row['job_id']; // Đảm bảo chuyển về string để khớp với data-job-id của HTML
    }
    $stmt->close();
  } else {
    error_log("Error preparing query to fetch saved_jobs: " . $conn->error);
  }
}
$savedJobIdsJson = json_encode($savedJobIds);

?>
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
    <div class="title">Find jobs fast 24/7, the latest jobs nationwide.</div>
    <div class="subtitle">Access 40,000+ new job postings every day from thousands of reputable companies in Vietnam.
    </div>

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
        <option>Job Category</option>
        <option>IT & Software</option>
        <option>Marketing</option>
        <option>Finance</option>
        <option>Healthcare</option>
        <option>Government & Public Sector</option>
      </select>
      <input type="text" placeholder="Job title, company name">
      <input type="text" placeholder="Location">
      <button>Search</button>
    </div>

    <div class="main-content">
      <div class="left-menu">
        <ul>
          <li id="filter-fulltime" class="job-type-filter">Full-time</li>
          <li id="filter-parttime" class="job-type-filter">Part-time</li>
          <li id="filter-internship" class="job-type-filter">Internship</li>
          <li id="filter-freelance" class="job-type-filter">Freelance</li>
          <li id="filter-remote" class="job-type-filter">Remote</li>
        </ul>
        <script>
          document.querySelectorAll('.job-type-filter').forEach(function (item) {
            item.addEventListener('click', function () {
              const type = this.textContent.trim().toLowerCase();
              // Gọi hàm filterJobByType trong job_filter/job_type_filter.php qua AJAX
              fetch('job_filter/job_type_filter.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'job_type=' + encodeURIComponent(type)
              })
                .then(response => response.text())
                .then(data => {
                  // Xử lý kết quả trả về, ví dụ: hiển thị danh sách công việc đã lọc
                  // Bạn có thể thay đổi selector '.job-grid' nếu muốn hiển thị ở nơi khác
                  document.querySelector('.job-grid').innerHTML = data;
                });
            });
          });
        </script>

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
        <h2>🔥 Urgent Job Openings</h2>
        <div class="sort-dropdown">
          <button>Sort by ▾</button>
        </div>
      </div>

      <div class="job-filters">
        <button class="active">All</button>
        <button>IT & Software</button>
        <button>Marketing</button>
        <button>Finance</button>
        <button>Healthcare</button>
        <button>Government & Public Sector</button>
      </div>

      <div class="job-grid">
        <?php
        // Pagination logic
        $jobs_per_page = 9;
        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;

        // Get total jobs count
        $count_sql = "SELECT COUNT(*) as total FROM job";
        $count_result = $conn->query($count_sql);
        $total_jobs = $count_result ? (int) $count_result->fetch_assoc()['total'] : 0;
        $total_pages = ceil($total_jobs / $jobs_per_page);

        // Fetch jobs for current page
        $offset = ($page - 1) * $jobs_per_page;
        $sql = "SELECT id, job_title, company_logo, company_name, salary, job_location, created_at, post_duration 
          FROM job 
          LIMIT $jobs_per_page OFFSET $offset";
        $result = $conn->query($sql);

        // Output jobs (only 9 per page)
        if ($result && $result->num_rows > 0):
          while ($row = $result->fetch_assoc()):
            $created_at = new DateTime($row['created_at']);
            $post_duration = (int) $row['post_duration'];
            $expire_at = clone $created_at;
            $expire_at->modify("+$post_duration days");
            $now = new DateTime();
            $interval = $now->diff($expire_at);
            $days_left = (int) $interval->format('%r%a');
            $days_left_text = $days_left > 0 ? $days_left . ' days left' : 'Expired';
            $job_id = (int) $row['id'];
            $isJobAlreadySaved = in_array((string) $job_id, $savedJobIds);
            if ($isJobAlreadySaved) {
              $savedClass = 'active';
            } else {
              $savedClass = '';
            }
            ?>
            <a href="jobdetail.php?id=<?php echo $job_id; ?>" style="text-decoration:none;color:inherit;">
              <div class="job-card">
                <div class="job-header">
                  <h3><?php echo htmlspecialchars($row['job_title']); ?></h3>
                  <?php
                  $isLoggedIn = isset($_SESSION['jobseeker_id']);
                  $userId = $isLoggedIn ? (int) $_SESSION['jobseeker_id'] : 0;
                  ?>
                  <button class="save-btn" aria-pressed="<?php echo $isJobAlreadySaved ? 'true' : 'false'; ?>"
                    title="Save job" data-job-id="<?php echo $job_id; ?>">
                    <svg class="heart-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#e74c3c"
                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path
                        d="M12 21s-6.5-5.5-8.5-8.5C1.5 9.5 3.5 6 7 6c1.7 0 3.4 1.1 4.1 2.7C11.6 7.1 13.3 6 15 6c3.5 0 5.5 3.5 3.5 6.5C18.5 15.5 12 21 12 21z"
                        fill="<?php echo $isJobAlreadySaved ? '#e74c3c' : '#fff'; ?>" />
                    </svg>
                  </button>
                  <script>
                    // Các biến PHP truyền sang JavaScript
                    window.isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
                    window.currentUserId = <?php echo $userId; ?>;
                    // Danh sách Job ID đã lưu của người dùng hiện tại, lấy từ database
                    window.initialSavedJobIds = <?php echo $savedJobIdsJson; ?>;

                    document.addEventListener('DOMContentLoaded', function () {
                      // Khởi tạo trạng thái cho localStorage nếu chưa có hoặc không khớp
                      // Điều này đảm bảo trạng thái localStorage luôn phản ánh dữ liệu từ DB khi tải trang
                      localStorage.setItem('savedJobs', JSON.stringify(window.initialSavedJobIds));

                      document.querySelectorAll('.save-btn').forEach(function (btn) {
                        const jobId = btn.getAttribute('data-job-id');
                        const heartPath = btn.querySelector('.heart-icon path');
                        // Lấy trạng thái hiện tại từ localStorage (đã được đồng bộ với DB ở trên)
                        let savedJobs = JSON.parse(localStorage.getItem('savedJobs') || '[]');

                        // Cập nhật trạng thái ban đầu của nút dựa trên dữ liệu PHP (và localStorage)
                        if (savedJobs.includes(jobId)) {
                          heartPath.setAttribute('fill', '#e74c3c');
                          btn.setAttribute('aria-pressed', 'true');
                        } else {
                          heartPath.setAttribute('fill', '#fff');
                          btn.setAttribute('aria-pressed', 'false');
                        }

                        btn.addEventListener('click', function (e) {
                          e.preventDefault(); // Ngăn chặn hành vi mặc định của button

                          // Kiểm tra đăng nhập
                          if (!window.isLoggedIn) {
                            showPopup('Please login to save jobs to your account.');
                            return;
                          }

                          let currentSavedJobs = JSON.parse(localStorage.getItem('savedJobs') || '[]');
                          const isCurrentlySaved = btn.getAttribute('aria-pressed') === 'true';
                          let action;

                          if (!isCurrentlySaved) { // Chưa lưu -> Lưu
                            heartPath.setAttribute('fill', '#e74c3c');
                            btn.setAttribute('aria-pressed', 'true');
                            currentSavedJobs.push(jobId);
                            showPopup('Job saved successfully!');
                            action = 'save';
                          } else { // Đã lưu -> Hủy lưu
                            heartPath.setAttribute('fill', '#fff');
                            btn.setAttribute('aria-pressed', 'false');
                            currentSavedJobs = currentSavedJobs.filter(id => id !== jobId);
                            showPopup('Job unsaved successfully.');
                            action = 'unsave';
                          }
                          localStorage.setItem('savedJobs', JSON.stringify(currentSavedJobs));
                          saveJobAjax(jobId, action); // Gửi yêu cầu AJAX
                        });
                      });

                      // Hàm gửi yêu cầu AJAX đến save_job_action.php
                      function saveJobAjax(jobId, action) {
                        fetch('save_job_action.php', { // Tên file xử lý AJAX mới
                          method: 'POST',
                          headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                          },
                          body: 'action=' + encodeURIComponent(action) + '&job_id=' + encodeURIComponent(jobId)
                        })
                          .then(response => {
                            if (!response.ok) {
                              throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json(); // Chờ phản hồi JSON từ server
                          })
                          .then(data => {
                            if (data.status === 'success') {
                              console.log('Database update successful:', data.message);
                            } else {
                              console.error('Database update failed:', data.message);
                              // Optionally handle error here, e.g., revert UI changes
                              showPopup('Error: ' + data.message); // Show error from server
                            }
                          })
                          .catch(error => {
                            console.error('AJAX request error:', error);
                            showPopup('Connection or processing error. Please try again.');
                          });
                      }

                      // Hàm hiển thị Popup (giữ nguyên từ code của bạn)
                      function showPopup(message) {
                        let existing = document.getElementById('job-popup-message');
                        if (existing) {
                          existing.remove();
                        }
                        let popup = document.createElement('div');
                        popup.id = 'job-popup-message';
                        popup.textContent = message;
                        popup.style.position = 'fixed';
                        popup.style.top = '30px';
                        popup.style.left = '50%';
                        popup.style.transform = 'translateX(-50%)';
                        popup.style.background = '#fff';
                        popup.style.color = '#e74c3c';
                        popup.style.padding = '12px 28px';
                        popup.style.borderRadius = '8px';
                        popup.style.boxShadow = '0 2px 12px rgba(0,0,0,0.15)';
                        popup.style.zIndex = 9999;
                        popup.style.opacity = 1;
                        document.body.appendChild(popup);
                        setTimeout(() => {
                          popup.style.transition = 'opacity 0.4s';
                          popup.style.opacity = 0;
                          setTimeout(() => popup.remove(), 400);
                        }, 1200);
                      }
                    });
                  </script>

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
      </div>

      <div class="pagination">
        <a href="<?php echo $page > 1 ? '?page=' . ($page - 1) : 'javascript:void(0);'; ?>" class="arrow<?php if ($page <= 1)
                       echo ' disabled'; ?>" <?php if ($page <= 1)
                           echo 'tabindex="-1" aria-disabled="true"'; ?>>
          &larr;
        </a>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <a href="?page=<?php echo $i; ?>" class="page-number<?php if ($i == $page)
               echo ' active'; ?>">
            <?php echo $i; ?>
          </a>
        <?php endfor; ?>
        <a href="<?php echo $page < $total_pages ? '?page=' . ($page + 1) : 'javascript:void(0);'; ?>" class="arrow<?php if ($page >= $total_pages)
                       echo ' disabled'; ?>" <?php if ($page >= $total_pages)
                           echo 'tabindex="-1" aria-disabled="true"'; ?>>
          &rarr;
        </a>
      </div>
      <style>
        .pagination .page-number {
          display: inline-block;
          min-width: 24px;
          padding: 4px 8px;
          margin: 0 2px;
          border-radius: 6px;
          background: #ccc;
          color: #333;
          font-weight: bold;
          text-align: center;
          text-decoration: none;
          transition: background 0.2s, color 0.2s;
        }

        .pagination .page-number.active {
          background: #d70018;
          color: #fff;
          pointer-events: none;
        }

        .pagination .arrow {
          display: inline-block;
          min-width: 24px;
          padding: 4px 8px;
          margin: 0 2px;
          border-radius: 6px;
          background: #eee;
          color: #333;
          font-weight: bold;
          text-align: center;
          cursor: pointer;
          text-decoration: none;
          transition: background 0.2s, color 0.2s;
        }

        .pagination .arrow.disabled {
          background: #f3f3f3;
          color: #bbb;
          cursor: not-allowed;
          pointer-events: none;
        }

        .pagination a {
          text-decoration: none;
        }
      </style>
  </section>


  <section class="section-3">
    <div class="container">
      <div class="header">
        <h2>🌟 Featured Companies</h2>
        <a href="#" class="view-all">View all →</a>
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
      <h3>Opportunities to apply for attractive jobs at top companies</h3>
      <p>With the rapid development of the economy... professional environment.</p>

      <h3>Why should you look for jobs at JobHive?</h3>
      <ul>
        <li><strong>Quality Jobs</strong><br />
          Thousands of high-quality job postings... to your CV.</li>
        <li><strong>Free Beautiful CV Builder</strong><br />
          Many beautiful CV templates... in just 5 minutes.</li>
        <li><strong>Job Seeker Support</strong><br />
          Employers... view your CV and send invitations.</li>
      </ul>

      <p>At JobHive, you can find... the best salary!</p>
    </div>
  </section>

</div>