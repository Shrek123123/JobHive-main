<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Employer Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        .top-bar {
            background-color: #943737;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            padding: 10px 20px;
        }

        .top-bar .title {
            font-weight: bold;
            font-size: 15px;
        }

        .top-bar .company {
            display: flex;
            align-items: center;
        }

        .top-bar .company img {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .top-bar .company-info {
            text-align: right;
            font-size: 12px;
        }

        .top-bar .status {
            font-size: 11px;
            color: #ffdddd;
        }

        .main {
            display: flex;
        }

        .sidebar {
            width: 160px;
            border-right: 1px solid #ccc;
            padding: 10px;
            background: #fff;
        }

        .sidebar h3 {
            margin-top: 20px;
            font-size: 14px;
        }

        .sidebar button {
            width: 100%;
            padding: 6px;
            margin-bottom: 10px;
            font-size: 13px;
            border: 1px solid black;
            background-color: white;
            cursor: pointer;
        }

        .sidebar button:hover {
            background-color: #f2f2f2;
        }

        .applicant-card {
            background-color: #b76d6d;
            color: white;
            border-radius: 6px;
            padding: 6px;
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .applicant-card img {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .applicant-info {
            font-size: 13px;
        }

        .status-viewed {
            font-size: 11px;
            color: #b2ffb2;
        }

        .status-new {
            font-size: 11px;
            color: #cce0ff;
        }

        .view-more {
            font-size: 12px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
            border-radius: 4px;
        }

        .content-area {
            flex-grow: 1;
            background-color: #fff;
        }

        #btn-jobposts.active {
            background: #b23b3b;
            color: #fff;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Top bar -->
    <div class="top-bar">
        <div class="title">Employer profile</div>
        <div class="company">
            <img src="https://via.placeholder.com/34" alt="company logo">
            <?php
            // Lấy employer_id từ URL
            $employer_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            // Lấy ảnh đại diện employer
            $sql = "SELECT profile_pic FROM employer_profile WHERE id = $employer_id LIMIT 1";
            $result = $conn->query($sql);
            $profile_pic = "https://via.placeholder.com/34";
            if ($result && $row = $result->fetch_assoc()) {
                $profile_pic = !empty($row['profile_pic']) ? htmlspecialchars($row['profile_pic']) : $profile_pic;
            }
            $conn->close();
            $company_name = "Tên công ty";
            ?>
            <img src="<?php echo $profile_pic; ?>" alt="company logo">
            <div class="company-info">
                <div><strong><?php echo $company_name; ?></strong></div>
                <div class="status">● Online</div>
            </div>
        </div>
    </div>

    <!-- Main layout -->
    <div class="main">
        <!-- Sidebar -->
        <div class="sidebar">
            <button>Post a job</button>
            <button id="btn-jobposts">My job posts</button>
            <button>My profile</button>
            <button>Change person information</button>

            <h3>Applicant profiles</h3>

            <!-- Applicants -->
            <div class="applicant-card">
                <img src="<?php echo $user1['avatar']; ?>" alt="avatar">
                <div class="applicant-info">
                    Alex<br>
                    <span class="status-viewed">✔ Viewed</span>
                </div>
            </div>

            <div class="applicant-card">
                <img src="<?php echo $user2['avatar']; ?>" alt="avatar">
                <div class="applicant-info">
                    Selena<br>
                    <span class="status-new">★ New</span>
                </div>
            </div>

            <div class="applicant-card">
                <img src="<?php echo $user3['avatar']; ?>" alt="avatar">
                <div class="applicant-info">
                    Tyler<br>
                    <span class="status-new">★ New</span>
                </div>
            </div>

            <div class="applicant-card">
                <img src="<?php echo $user4['avatar']; ?>" alt="avatar">
                <div class="applicant-info">
                    Patrica<br>
                    <span class="status-new">★ New</span>
                </div>
            </div>

            <div class="applicant-card">
                <img src="<?php echo $user5['avatar']; ?>" alt="avatar">
                <div class="applicant-info">
                    Miranda<br>
                    <span class="status-new">★ New</span>
                </div>
            </div>

            <div class="view-more">View more</div>
        </div>

        <!-- Right side content -->
        <div class="content-area">

        </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#btn-jobposts').on('click', function () {
            // Remove active class from all buttons
                $('.sidebar button').removeClass('active');
            // Add active class to the clicked button
                $(this).addClass('active');
            // Load the job posts content-area
            $('.content-area').html('<div style="padding:30px;text-align:center;">Loading...</div>');
            $.get('employerprofile/jobposts-content.php', function (data) {
                $('.content-area').html(data);
            });
        });
    </script>
</body>

</html>