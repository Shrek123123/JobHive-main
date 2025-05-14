<style>
body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(to right, #c31432, #240b36);
      color: white;
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

    .user-type-section {
      display: flex;
      justify-content: center;
      gap: 40px;
      margin: 30px 0 10px 0;
    }
    .user-type-card {
      background: #fff;
      color: #333;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      padding: 24px 32px;
      text-align: center;
      width: 260px;
    }
    .user-type-card img {
      width: 60px;
      height: 60px;
      margin-bottom: 12px;
    }
    .user-type-card button {
      margin-top: 12px;
      background: #d70018;
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 8px 18px;
      cursor: pointer;
    }
    .job-section {
  background-color: #f9f5f5;
  padding: 40px 20px;
}

.job-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: #660000;
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

.job-listings {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 20px;
}

.job-card {
  background-color: white;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  color: #333;
}

.job-card .job-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
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

.job-card p {
  margin: 4px 0;
  font-size: 14px;
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

.save-job {
  font-size: 22px;
  color: #bbb;
  cursor: pointer;
  margin-left: 10px;
  transition: color 0.2s;
}
.save-job.saved {
  color: #d70018;
  content: '\2605';
}
</style>

<div class="container">
    <div class="title">Tìm việc làm nhanh 24h, việc làm mới nhất trên toàn quốc.</div>
    <div class="subtitle">Tiếp cận 40,000+ tin tuyển dụng việc làm mới mỗi ngày từ hàng nghìn doanh nghiệp uy tín tại Việt Nam</div>

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

  <div class="user-type-section">
  <div class="user-type-card">
    <img src="image/jobseeker.png" alt="Job Seeker" />
    <h3>Ứng viên</h3>
    <p>Tìm kiếm và lưu việc làm phù hợp, ứng tuyển nhanh chóng.</p>
    <button>Đăng nhập Ứng viên</button>
  </div>
  <div class="user-type-card">
    <img src="image/employer.png" alt="Employer" />
    <h3>Nhà tuyển dụng</h3>
    <p>Đăng tin tuyển dụng, quản lý ứng viên dễ dàng.</p>
    <button>Đăng nhập Nhà tuyển dụng</button>
  </div>
</div>

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

    <div class="job-card">
      <div class="job-header">
        <h4>Nhân viên IT (CNTT phần cứng)</h4>
        <img src="image/nhanvienitjobhive.png" alt="Logo công ty">
        <span class="save-job" title="Lưu công việc">&#9734;</span>
      </div>
      <p class="company">Công Ty Cổ Phần Đầu Tư Công Nghệ Hacom</p>
      <p class="salary">💰 10 - 11 triệu</p>
      <p class="location">📍 Hà Nội</p>
      <p class="posted">🕒 3 ngày trước</p>
    </div>

    <div class="job-card">
      <div class="job-header">
        <h4>Junior IT Support</h4>
        <img src="image/junioritsupportjobhive.png" alt="Logo công ty">
        <span class="save-job" title="Lưu công việc">&#9734;</span>
      </div>
      <p class="company">Công Ty TNHH Leap Strategies Việt Nam</p>
      <p class="salary">💰 10 - 15 triệu</p>
      <p class="location">📍 Hà Nội</p>
      <p class="posted">🕒 5 ngày trước</p>
    </div>

 <div class="job-card">
      <div class="job-header">
        <h4>Chuyên viên công nghệ thông tin</h4>
        <img src="image/chuyenviencongnghethongtinjobhive.png" alt="Logo công ty">
        <span class="save-job" title="Lưu công việc">&#9734;</span>
      </div>
      <p class="company">Công Ty Cổ Phần Quản Lý và phát triển BĐS</p>
      <p class="salary">💰 18 - 20 triệu</p>
      <p class="location">📍 Hà Nội</p>
      <p class="posted">🕒 5 ngày trước</p>
    </div>

    <div class="job-card">
      <div class="job-header">
        <h4>Content Marketing/Growth</h4>
        <img src="image/contentmarketinggrowthjobhive.png" alt="Logo công ty">
        <span class="save-job" title="Lưu công việc">&#9734;</span>
      </div>
      <p class="company">Công Ty TabTab Việt Nam</p>
      <p class="salary">💰 12 -25 triệu</p>
      <p class="location">📍 Hà Nội</p>
      <p class="posted">🕒 2 ngày trước</p>
    </div>

 <div class="job-card">
      <div class="job-header">
        <h4>Financial Planning & Analysis</h4>
        <img src="image/financialplanning&analysisjobhive.png" alt="Logo công ty">
        <span class="save-job" title="Lưu công việc">&#9734;</span>
      </div>
      <p class="company">Công Ty Cổ Phần Giáo Dục SAPP</p>
      <p class="salary">💰 12 - 18 triệu</p>
      <p class="location">📍 Hà Nội</p>
      <p class="posted">🕒 8 ngày trước</p>
    </div>

 <div class="job-card">
      <div class="job-header">
        <h4>Medical Representative (ETC)</h4>
        <img src="image/medicalrepresentative(etc)jobhive.png" alt="Logo công ty">
        <span class="save-job" title="Lưu công việc">&#9734;</span>
      </div>
      <p class="company">Abbott Laboratories</p>
      <p class="salary">💰 10 - 11 triệu</p>
      <p class="location">📍 Hà Nội</p>
      <p class="posted">🕒 15 ngày trước</p>
    </div>


  </div>

  <div class="pagination">
    <span class="dot active"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
  </div>
</div>

<div class="saved-jobs-section">
  <h3>⭐ Công việc đã lưu</h3>
  <div id="saved-jobs-list">
    <p>Chưa có công việc nào được lưu.</p>
  </div>
</div>

<script>
document.querySelectorAll('.save-job').forEach(function(btn) {
  btn.addEventListener('click', function() {
    btn.classList.toggle('saved');
    btn.innerHTML = btn.classList.contains('saved') ? '★' : '☆';
    updateSavedJobs();
  });
});

function updateSavedJobs() {
  const saved = Array.from(document.querySelectorAll('.job-card'))
    .filter(card => card.querySelector('.save-job').classList.contains('saved'))
    .map(card => card.outerHTML.replace('&#9734;', '★'));
  const savedList = document.getElementById('saved-jobs-list');
  if (saved.length === 0) {
    savedList.innerHTML = '<p>Chưa có công việc nào được lưu.</p>';
  } else {
    savedList.innerHTML = saved.join('');
  }
}
</script>