<?php
session_start();
require_once '../config.php'; // Adjust path as admindashboard.php is in admin folder

// Check if admin is logged in, otherwise redirect
if (!isset($_SESSION['usernameadmin'])) {
    header('Location: ../index.php'); // Redirect to login page or home page
    exit();
}

$feedbacks = []; // Initialize an empty array to store feedbacks

// Fetch feedbacks from the database
if (isset($conn) && $conn->ping()) {
    // Select all columns from the feedback table, and join with user table to get username
    $sql = "SELECT f.id, f.user_id, f.user_type, f.content, f.star_rating, f.created_at, u.username 
            FROM feedback f
            JOIN user u ON f.user_id = u.id
            ORDER BY f.created_at DESC"; // Order by most recent feedback
    
    $result = $conn->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $feedbacks[] = $row;
        }
        $result->free(); // Free result set
    } else {
        // Handle query error
        echo "Error fetching feedbacks: " . $conn->error;
    }
    $conn->close();
} else {
    echo "Database connection error.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Feedbacks - Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f0f2;
            margin: 0;
            padding: 0;
            display: flex;
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

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
        }

        .sidebar ul li a:hover {
            color: white;
        }

        .user-status {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .status-dot {
            height: 10px;
            width: 10px;
            background-color: #4caf50;
            border-radius: 50%;
        }

        .main-content {
            margin-left: 220px;
            padding: 20px;
            flex-grow: 1;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .feedback-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .feedback-card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }

        .feedback-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #eee;
        }

        .feedback-user-info {
            font-weight: bold;
            color: #333;
        }

        .feedback-date {
            font-size: 0.85em;
            color: #777;
        }

        .feedback-content {
            margin-bottom: 10px;
            line-height: 1.6;
            color: #555;
        }

        .feedback-rating {
            font-size: 1.1em;
            color: #f4b400; /* Google's yellow for stars */
            margin-top: 5px;
        }

        .feedback-rating .star {
            display: inline-block;
            margin-right: 2px;
        }

        .feedback-rating .star.filled {
            color: #f4b400;
        }
        .feedback-rating .star.empty {
            color: #ccc;
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

    <div class="main-content">
        <div class="top-bar">
            <h1>User Feedbacks</h1>
            <form method="post" action="adminlogout.php" style="display: inline;">
                <button type="submit" name="admin_logout"
                    style="padding: 8px 16px; background: #e74c3c; color: #fff; border-radius: 5px; border: none; font-weight: bold; cursor: pointer;">
                    Logout
                </button>
            </form>
        </div>

        <div class="feedback-container">
            <?php if (empty($feedbacks)): ?>
                <p style="text-align: center; color: #888;">No feedback entries found.</p>
            <?php else: ?>
                <?php foreach ($feedbacks as $feedback): ?>
                    <div class="feedback-card">
                        <div class="feedback-header">
                            <div class="feedback-user-info">
                                From: <?php echo htmlspecialchars($feedback['username']); ?> 
                                (<?php echo htmlspecialchars($feedback['user_type']); ?>)
                            </div>
                            <div class="feedback-date">
                                <?php echo date('F j, Y, g:i a', strtotime($feedback['created_at'])); ?>
                            </div>
                        </div>
                        <div class="feedback-content">
                            <?php echo nl2br(htmlspecialchars($feedback['content'])); ?>
                        </div>
                        <div class="feedback-rating">
                            Rating:
                            <?php 
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $feedback['star_rating']) {
                                    echo '<span class="star filled">&#9733;</span>'; // Filled star
                                } else {
                                    echo '<span class="star empty">&#9733;</span>'; // Empty star
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>