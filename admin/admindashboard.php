<?php
session_start();
// Điều chỉnh đường dẫn tới config.php vì admindashboard.php nằm trong thư mục admin
require_once '../config.php'; // Giả định config.php nằm ở thư mục gốc của project

if (!isset($_SESSION['usernameadmin'])) {
    if (isset($_SERVER['HTTP_REFERER'])) {
        echo "Bạn đến từ: " . $_SERVER['HTTP_REFERER'];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Không xác định trang trước đó.";
        header('Location: ../index.php'); // Giả định index.php nằm ở thư mục gốc
    }
}

// --- Lấy dữ liệu động từ database ---
$total_employer_accounts = 0;
$total_jobseeker_accounts = 0;
$total_job_posts = 0;
$job_post_pendings = 0;
$user_feedbacks = 0;

// Lấy tổng số tài khoản Employer
$sql_employers = "SELECT COUNT(*) AS total FROM user WHERE user_type = 'employer'";
$result_employers = $conn->query($sql_employers);
if ($result_employers && $result_employers->num_rows > 0) {
    $row = $result_employers->fetch_assoc();
    $total_employer_accounts = $row['total'];
}

// Lấy tổng số tài khoản Jobseeker
$sql_jobseekers = "SELECT COUNT(*) AS total FROM user WHERE user_type = 'jobseeker'";
$result_jobseekers = $conn->query($sql_jobseekers);
if ($result_jobseekers && $result_jobseekers->num_rows > 0) {
    $row = $result_jobseekers->fetch_assoc();
    $total_jobseeker_accounts = $row['total'];
}

// Lấy tổng số Job Posts (tất cả các trạng thái)
$sql_total_jobs = "SELECT COUNT(*) AS total FROM job";
$result_total_jobs = $conn->query($sql_total_jobs);
if ($result_total_jobs && $result_total_jobs->num_rows > 0) {
    $row = $result_total_jobs->fetch_assoc();
    $total_job_posts = $row['total'];
}

// Lấy số Job Post Pendings (trạng thái 'pending_review')
$sql_pending_jobs = "SELECT COUNT(*) AS total FROM job WHERE status = 'pending_review'";
$result_pending_jobs = $conn->query($sql_pending_jobs);
if ($result_pending_jobs && $result_pending_jobs->num_rows > 0) {
    $row = $result_pending_jobs->fetch_assoc();
    $job_post_pendings = $row['total'];
}

// Lấy tổng số User Feedbacks
$sql_feedbacks = "SELECT COUNT(*) AS total FROM feedback"; // Giả định bảng feedbacks có tên là 'feedback'
$result_feedbacks = $conn->query($sql_feedbacks);
if ($result_feedbacks && $result_feedbacks->num_rows > 0) {
    $row = $result_feedbacks->fetch_assoc();
    $user_feedbacks = $row['total'];
}

// Đóng kết nối database sau khi đã lấy xong dữ liệu
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
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

        /* Thêm style cho thẻ a trong li để không bị gạch chân và màu mặc định */
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            /* Để toàn bộ li là khu vực click */
        }

        .sidebar ul li a:hover {
            color: white;
            /* Giữ nguyên màu khi hover */
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
            <li><a href="#">Change homepage picture</a></li>
            <li><a href="#">Users</a></li>
            <li><a href="jobpending.php">Review Job Posts</a></li>
            <li><a href="#">Review Users</a></li>
            <li><a href="feedbackcheck.php">Feedbacks</a></li>
        </ul>
    </div>
    <div class="main">
        <div class="top-bar">
            <h1>Dashboard</h1>
            <div>
                <img src="" alt="Profile" style="width: 32px; height: 32px; border-radius: 50%; background: #ccc;">
            </div>
            <form method="post" action="adminlogout.php" style="display: inline;">
                <button type="submit" name="admin_logout"
                    style="padding: 8px 16px; background: #e74c3c; color: #fff; border-radius: 5px; border: none; font-weight: bold; cursor: pointer;">
                    Logout
                </button>
            </form>
        </div>
        <div class="cards">
            <div class="card yellow">
                <h2><?php echo $total_employer_accounts; ?></h2>
                <p>Total Employer Accounts</p>
            </div>
            <div class="card yellow">
                <h2><?php echo $total_jobseeker_accounts; ?></h2>
                <p>Total Job Seeker Accounts</p>
            </div>
            <div class="card green">
                <h2><?php echo $total_job_posts; ?></h2>
                <p>Total Job Posts</p>
            </div>
            <div class="card blue">
                <h2><?php echo $job_post_pendings; ?></h2>
                <p>Job Post Pendings</p>
            </div>
            <div class="card purple">
                <h2><?php echo $user_feedbacks; ?></h2>
                <p>User Feedbacks</p>
            </div>
        </div>
        <div class="content-grid">
            <div class="box">
                <img src="https://www.presentationgo.com/wp-content/uploads/2018/12/Free-Growth-Arrow-PowerPoint-Template-Chart.png"
                    width="100%" alt="Graph" />
            </div>
            <div class="box">
                <h3>Access Activities</h3>
                <ul>
                    <li>Post new job</li>
                    <li>Recruitment</li>
                    <li>Apply</li>
                </ul>
            </div>
        </div>
        <div class="content-grid" style="margin-top: 20px;">
            <div class="box">
                <h3>Notifications</h3>
            </div>
            <div class="box">
                <h3>Page Views</h3>
            </div>
        </div>
    </div>
</body>

</html>