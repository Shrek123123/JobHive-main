<?php
session_start();
require_once __DIR__ . '/../config.php';

if (!isset($_SESSION['usernameadmin'])) {
  if (isset($_SERVER['HTTP_REFERER'])) {
    echo "Bạn đến từ: " . $_SERVER['HTTP_REFERER'];
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
  } else {
    echo "Không xác định trang trước đó.";
    header('Location: index.php');
  }
}

//Display information
function getCount($conn, $sql)
{
  $result = $conn->query($sql);
  if ($result && $row = $result->fetch_assoc()) {
    return $row[array_key_first($row)];
  }
  return 0;
}

$total_employers = getCount($conn, "SELECT COUNT(*) AS c FROM user WHERE user_type = 'employer'");
$total_seekers = getCount($conn, "SELECT COUNT(*) AS c FROM user WHERE user_type = 'jobseeker'");
$total_jobs = getCount($conn, "SELECT COUNT(*) AS c FROM job");
$total_feedbacks = getCount($conn, "SELECT COUNT(*) AS c FROM jobseekerfeedback") +
  getCount($conn, "SELECT COUNT(*) AS c FROM employerfeedback");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f3f0f2;
    }

    .sidebar {
      width: 200px;
      background-color: #0b1e45;
      color: white;
      height: 100vh;
      position: fixed;
      padding: 20px 10px;
    }

    .sidebar h2 {
      margin-top: 0;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
    }

    .sidebar ul li {
      margin: 20px 0;
      padding: 10px;
      background-color: #15294c;
      border-radius: 5px;
    }

    .sidebar ul li:hover {
      background-color: #1e3a66;
      cursor: pointer;
    }

    .main {
      margin-left: 220px;
      padding: 20px;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .cards {
      display: flex;
      gap: 15px;
      margin: 20px 0;
    }

    .card {
      flex: 1;
      padding: 15px;
      border-radius: 10px;
      color: white;
      text-align: center;
    }

    .yellow {
      background-color: #f4b400;
    }

    .green {
      background-color: #0f9d58;
    }

    .blue {
      background-color: #4285f4;
    }

    .purple {
      background-color: #9b59b6;
    }

    .content-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 20px;
    }

    .box {
      background-color: white;
      padding: 15px;
      border-radius: 10px;
    }

    .user-status {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .status-dot {
      height: 10px;
      width: 10px;
      background-color: #4caf50;
      border-radius: 50%;
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <h2>Admin</h2>
    <div class="user-status">
      <div class="status-dot"></div>
      <span>Online</span>
    </div>
    <ul>
      <li>Dashboard</li>
      <li>Job Posts</li>
      <li>Feedback</li>
      <li>Add Job</li>
    </ul>
  </div>
  <div class="main">
    <div class="top-bar">
      <h1>Dashboard</h1>
      <div>
        <img src="../image/logo.png" alt="Profile" style="width: 150px; height: 50px; border-radius: 30%; background: #ccc;">
      </div>
      <form method="post" action="/JobHive-main/admin/adminlogout.php" style="display: inline;">
        <button type="submit" name="admin_logout" style="padding: 8px 16px; background: #e74c3c; color: #fff; border-radius: 5px; border: none; font-weight: bold; cursor: pointer;">
          Logout
        </button>
      </form>
    </div>
    <div class="cards">
      <div class="card yellow">
        <h2><?= $total_employers ?></h2>
        <p>Total Employer Accounts</p>
      </div>
      <div class="card yellow">
        <h2><?= $total_seekers ?></h2>
        <p>Total Job Seeker Accounts</p>
      </div>
      <div class="card green">
        <h2><?= $total_jobs ?></h2>
        <p>Total Job Posts</p>
      </div>
      <div class="card purple">
        <h2><?= $total_feedbacks ?></h2>
        <p>User Feedbacks</p>
      </div>
    </div>
    <div class="">
      <table class="table table-responsive">
        <thead>
          <tr>
            <th>Id</th>
            <th>Company Name</th>
            <th>Job Title</th>
            <th>Job Location</th>
            <th>Salary</th>
            <th>Job Type</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM job ORDER BY created_at DESC";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['company_name']}</td>
                      <td>{$row['job_title']}</td>
                      <td>{$row['job_location']}</td>
                      <td>{$row['salary']}</td>
                      <td>{$row['job_type']}</td>
                      <td>{$row['contact_email']}</td>
                      <td>{$row['contact_phone']}</td>
                      <td>
                        <a href='editjob.php?job_id={$row['id']}' class='btn btn-primary'>Edit</a>
                        <a href='deletejob.php?job_id={$row['id']}' class='btn btn-danger'>Delete</a> 
                      </td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='7'>No job posts available</td></tr>";
          }

          ?>


      </table>

    </div>
  </div>
</body>

</html>