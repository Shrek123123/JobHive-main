<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <job_title>Quick Search</job_title>
  <style>
    /* Tùy chỉnh style cho nhanh gọn */
    .quick-search {
      display: flex;
      gap: 8px;
      margin: 20px;
    }

    .quick-search input,
    .quick-search select {
      padding: 6px;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <h1>Quick Search</h1>
  <form class="quick-search"
    method="GET"
    action="index.php?action=quickResults">

    <input type="text"
      name="job_location"
      placeholder="Địa điểm">

    <select name="job_type">
      <option value="">-- Job Type --</option>
      <option value="full-time">Full-time</option>
      <option value="part-time">Part-time</option>
      <option value="internship">Internship</option>
      <option value="contract">Contract</option>
    </select>

    <select name="job_category">
      <option value="">-- Job job_category --</option>
      <option value="IT">IT</option>
      <option value="Marketing">Marketing</option>
      <option value="Finance">Finance</option>
      <option value="Healthcare">Healthcare</option>
    </select>

    <button type="submit">🔍 Tìm nhanh</button>
  </form>
</body>

</html>