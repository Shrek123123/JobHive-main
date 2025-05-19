<!-- Search_result.php/job/view -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả tìm kiếm việc làm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .job {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
        }
        .job h3 {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <h1>Kết quả tìm kiếm</h1>

    <?php if (!empty($jobs)): ?>
        <p>Đã tìm thấy <strong><?php echo count($jobs); ?></strong> công việc phù hợp:</p>

        <?php foreach ($jobs as $job): ?>
            <div class="job">
                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                <p><strong>Công ty:</strong> <?php echo htmlspecialchars($job['company_name']); ?></p>
                <p><strong>Lương:</strong> <?php echo htmlspecialchars($job['salary']); ?></p>
                <p><strong>Vị trí:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                <p><strong>Loại hình:</strong> <?php echo htmlspecialchars($job['job_type']); ?></p>
                <p><strong>Kinh nghiệm:</strong> <?php echo htmlspecialchars($job['experience_level']); ?></p>
                <p><strong>Ngành nghề:</strong> <?php echo htmlspecialchars($job['industry']); ?></p>
            </div>
        <?php endforeach; ?>

    <?php else: ?>
        <p>Không tìm thấy công việc nào phù hợp với tiêu chí bạn đã nhập.</p>
    <?php endif; ?>

    <p><a href="index.php?action=home">← Quay lại</a></p>
</body>
</html>
