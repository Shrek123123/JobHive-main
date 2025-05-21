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
    
    ?>
    </html>
<!-- </html> -->