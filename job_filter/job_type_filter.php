<?php
// job_filter/job_type_filter.php

// Kết nối database (sửa lại đường dẫn, user, pass cho phù hợp)
require_once '../config.php';

// Lấy job_type từ POST
$job_type = isset($_POST['job_type']) ? trim(strtolower($_POST['job_type'])) : '';
if ($job_type === '') {
    echo '<div>No jobs found.</div>';
    exit;
}

// Map lại tên job_type nếu cần (ví dụ: Partime => Parttime)
if ($job_type === 'partime') $job_type = 'parttime';

// Query lấy job theo job_type
$stmt = $conn->prepare("SELECT id, job_title, company_logo, company_name, salary, job_location, created_at, post_duration 
    FROM job WHERE LOWER(job_type) = ? ORDER BY created_at DESC");
$stmt->bind_param("s", $job_type);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
        $created_at = new DateTime($row['created_at']);
        $post_duration = (int) $row['post_duration'];
        $expire_at = clone $created_at;
        $expire_at->modify("+$post_duration days");
        $now = new DateTime();
        $interval = $now->diff($expire_at);
        $days_left = (int) $interval->format('%r%a');
        $days_left_text = $days_left > 0 ? $days_left . ' days left' : 'Expired';
        $job_id = (int) $row['id'];
        ?>
        <a href="jobdetail.php?id=<?php echo $job_id; ?>" style="text-decoration:none;color:inherit;">
          <div class="job-card">
            <div class="job-header">
              <h3><?php echo htmlspecialchars($row['job_title']); ?></h3>
              <button class="save-btn">♥</button>
            </div>
            <div class="job-body">
              <img src="<?php echo htmlspecialchars($row['company_logo']); ?>" alt="Company Logo" class="company-logo">
              <div class="job-info">
                <div class="company-name"><?php echo htmlspecialchars($row['company_name']); ?></div>
                <div><span class="icon">💰</span> <?php echo htmlspecialchars($row['salary']); ?></div>
                <div><span class="icon">📍</span> <?php echo htmlspecialchars($row['job_location']); ?></div>
              </div>
            </div>
            <div class="divider"></div>
            <div class="job-footer">
              <div class="deadline"><?php echo $days_left_text; ?></div>
            </div>
          </div>
        </a>
        <?php
    endwhile;
else:
    echo '<div>No jobs found.</div>';
endif;

$stmt->close();
$conn->close();
?>