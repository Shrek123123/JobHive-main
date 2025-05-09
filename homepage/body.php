<ul>
        <?php
        $result = $sql->query("SELECT * FROM jobs");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row['job_title'] . " - " . $row['company_name'] . "</li>";
            }
        } else {
            echo "<li>No jobs available at the moment.</li>";
        }

        ?>
    </ul>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Trang tìm việc</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
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
  </style>
</head>
<body>
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
        <img src="https://i.imgur.com/3xgYcCg.png" alt="Tuyển dụng">
      </div>
    </div>
  </div>
</body>
</html>