<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <job_title>Tìm kiếm nâng cao</job_title>
  <style>
    .adv-search {
      max-width: 800px;
      margin: 30px auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-gap: 12px;
    }

    .adv-search label {
      font-weight: bold;
      margin-bottom: 4px;
      display: block;
    }

    .adv-search input,
    .adv-search select {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
    }

    .adv-search .full-width {
      grid-column: 1 / span 2;
    }

    .adv-search button {
      padding: 10px;
      font-size: 16px;
      grid-column: 1 / span 2;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <?php include_once __DIR__ . '/../../../homepage/header.php'; ?>

  <h1 style="text-align:center; margin:20px 0;">Tìm kiếm nâng cao</h1>
  <form class="adv-search" method="GET" action="index.php?action=results">
    <div>
      <label for="keyword">Từ khóa</label>
      <input type="text" id="keyword" name="keyword" placeholder="Ví dụ: Developer">
    </div>
    <div>
      <label for="company_name">Tên công ty</label>
      <input type="text" id="company_name" name="company_name" placeholder="Ví dụ: TechCorp">
    </div>
    <div>
      <label for="job_id">Job ID</label>
      <input type="number" id="job_id" name="job_id" placeholder="Số ID">
    </div>
    <div>
      <label for="job_location">Địa điểm</label>
      <input type="text" id="job_location" name="job_location" placeholder="Ví dụ: Hanoi">
    </div>
    <div>
      <label for="minSalary">Lương từ</label>
      <input type="number" id="minSalary" name="minSalary" placeholder="Ví dụ: 500">
    </div>
    <div>
      <label for="maxSalary">Lương đến</label>
      <input type="number" id="maxSalary" name="maxSalary" placeholder="Ví dụ: 2000">
    </div>
    <div>
      <label for="sort_by">Sắp xếp theo</label>
      <select id="sort_by" name="sort_by">
        <option value="">-- Chọn --</option>
        <option value="date">Ngày đăng (mới nhất)</option>
        <option value="salary">Lương (cao xuống thấp)</option>
      </select>
    </div>
    <div>
      <label for="job_category">Danh mục nghề</label>
      <select id="job_category" name="job_category">
        <option value="">-- Chọn --</option>
        <option value="IT">IT</option>
        <option value="Marketing">Marketing</option>
        <option value="Finance">Finance</option>
        <option value="Healthcare">Healthcare</option>
      </select>
    </div>
    <div>
      <label for="experience">Kinh nghiệm</label>
      <select id="experience" name="experience">
        <option value="">-- Chọn --</option>
        <option value="entry">Entry</option>
        <option value="mid">Mid</option>
        <option value="senior">Senior</option>
      </select>
    </div>
    <div>
      <label for="job_type">Loại hình</label>
      <select id="job_type" name="job_type">
        <option value="">-- Chọn --</option>
        <option value="full-time">Full-time</option>
        <option value="part-time">Part-time</option>
        <option value="internship">Internship</option>
        <option value="contract">Contract</option>
      </select>
    </div>
    <div>
      <label for="remote">Remote/Onsite</label>
      <select id="remote" name="remote">
        <option value="">-- Chọn --</option>
        <option value="remote">Remote</option>
        <option value="onsite">Onsite</option>
      </select>
    </div>
    <div>
      <label for="industry">Ngành nghề</label>
      <input type="text" id="industry" name="industry" placeholder="Ví dụ: Software">
    </div>
    <div class="full-width">
      <button type="submit">🔍 Tìm kiếm</button>
    </div>
  </form>

  <?php include_once __DIR__ . '/../../../homepage/footer.php'; ?>

  <!-- Bắt URL thủ công, đợi sau khi trang load hết -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Chọn đúng form Advanced Search
      const advForm = document.querySelector('form.adv-search');
      if (!advForm) return;

      advForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Ngăn trình duyệt gửi form theo cách mặc định bằng hàm prevenDefautl

        // Lấy tất cả field và chuyển thành chuỗi query
        const params = new URLSearchParams(new FormData(advForm)).toString(); // với các tham số vẫn được giữ nguyên
        // giống khi đẩy GET lên URL

        // Chuyển hướng thủ công về results với action=results
        window.job_location.href = `/JobHive-main/index.php?action=results&${params}`;
      });
    });
  </script>
</body>

</html>