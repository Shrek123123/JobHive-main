<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background-color: #f8f8f8;
        }
        .feedback-container {
            background: white;
            padding: 25px;
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
        }
        .stars { font-size: 24px; margin-bottom: 10px; }
        .stars i { color: #ccc; cursor: pointer; }
        .stars i.selected { color: gold; }
        textarea { width: 100%; height: 100px; margin-bottom: 15px; }
        button { padding: 10px 20px; background: green; color: white; border: none; }
        select { width: 100%; padding: 8px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <?php
    include 'homepage/header.php';
    
    ?>
<div class="feedback-container">
    <h2>Feedback về công ty</h2>
    <form action="submit_feedback.php" method="POST" onsubmit="return validateForm()">
        <label for="job_id">Chọn công ty muốn đánh giá:</label>
        <select name="job_id" id="job_id" required>
            <option value="">-- Chọn công ty --</option>
            <?php foreach ($jobs as $job): ?>
                <option value="<?= $job['id'] ?>"><?= htmlspecialchars($job['company_name']) ?></option>
            <?php endforeach; ?>
        </select>

        
        <input type="hidden" name="rating" id="ratingInput">
        <textarea name="feedback" placeholder="Nhập phản hồi tại đây..." required></textarea>
        <button type="submit">Gửi phản hồi</button>
    </form>
</div>


</body>
<?php
    include 'homepage/footer.php';
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connect.php'; // file kết nối cơ sở dữ liệu

    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $feedback = trim($_POST['feedback']);

    // Giả sử người dùng đã đăng nhập (jobseeker_id từ session)
    session_start();
    $jobseeker_id = $_SESSION['user_id'] ?? null;

    if ($jobseeker_id && $rating >= 1 && $rating <= 5) {
        $stmt = $conn->prepare("INSERT INTO jobseeker_feedback (jobseeker_id, feedback) VALUES (?, ?)");
        $stmt->bind_param("is", $jobseeker_id, $feedback);
        $stmt->execute();
        echo "<p style='color: green;'>Cảm ơn bạn đã gửi phản hồi!</p>";
    } else {
        echo "<p style='color: red;'>Vui lòng đăng nhập và đánh giá hợp lệ.</p>";
    }
}
?>

<style>
.feedback-form {
    max-width: 500px;
    margin: 30px auto;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.feedback-form h2 {
    margin-bottom: 20px;
    text-align: center;
}
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    margin-bottom: 20px;
}
.star-rating input {
    display: none;
}
.star-rating label {
    font-size: 25px;
    color: #ccc;
    cursor: pointer;
    padding: 0 5px;
}
.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #f5c518;
}
textarea {
    width: 100%;
    height: 100px;
    padding: 10px;
    margin-bottom: 15px;
    resize: vertical;
    border-radius: 5px;
    border: 1px solid #ccc;
}
button {
    background: #007BFF;
    color: white;
    border: none;
    padding: 10px 25px;
    cursor: pointer;
    border-radius: 5px;
}
button:hover {
    background: #0056b3;
}
</style>

<div class="feedback-form">
    <h2>Đánh giá & Góp ý</h2>
    <form method="POST">
        <div class="star-rating">
            <input type="radio" name="rating" value="5" id="star5"><label for="star5">★</label>
            <input type="radio" name="rating" value="4" id="star4"><label for="star4">★</label>
            <input type="radio" name="rating" value="3" id="star3"><label for="star3">★</label>
            <input type="radio" name="rating" value="2" id="star2"><label for="star2">★</label>
            <input type="radio" name="rating" value="1" id="star1"><label for="star1">★</label>
        </div>
        <textarea name="feedback" placeholder="Nhập phản hồi của bạn..." required></textarea>
        <button type="submit">Gửi phản hồi</button>
    </form>
</div>