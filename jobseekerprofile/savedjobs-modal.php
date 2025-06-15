<?php
require_once '../config.php';
?>
<div style="padding: 30px;">
    <h2 style="color: #b23b3b; margin-bottom: 20px;">Saved Jobs</h2>
    <div style="display: flex; flex-direction: column; gap: 18px;">
        <?php
        // Lấy jobseeker id từ URL (?jobseekerid=...)
        $jobseekerid = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($jobseekerid > 0) {
            // Lấy danh sách job_id đã lưu của user này
            $sql_saved = "SELECT job_id FROM saved_jobs WHERE user_id = ?";
            $stmt_saved = $conn->prepare($sql_saved);
            $stmt_saved->bind_param("i", $jobseekerid);
            $stmt_saved->execute();
            $result_saved = $stmt_saved->get_result();

            if ($result_saved->num_rows === 0) {
                echo '<div style="color: #888;">No saved jobs found.</div>';
            }

            while ($row_saved = $result_saved->fetch_assoc()):
                $jobid = $row_saved['job_id'];

                // Lấy thông tin job từ bảng job
                $sql_job = "SELECT * FROM job WHERE id = ?";
                $stmt_job = $conn->prepare($sql_job);
                $stmt_job->bind_param("i", $jobid);
                $stmt_job->execute();
                $result_job = $stmt_job->get_result();

                if ($result_job->num_rows === 0) {
                    // Nếu job không tồn tại (đã bị xóa), có thể bỏ qua hoặc xóa khỏi saved_jobs
                    continue;
                }
                $row = $result_job->fetch_assoc();

                // Xử lý dữ liệu
                $logo = !empty($row['company_logo']) ? htmlspecialchars($row['company_logo']) : 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=cover&w=120&q=80';
                $created_at = new DateTime($row['created_at']);
                $duration = intval($row['post_duration']);
                $expire_at = clone $created_at;
                $expire_at->modify("+$duration days");
                $now = new DateTime();
                $days_left = $now < $expire_at ? $now->diff($expire_at)->days : 0;
                $salary = htmlspecialchars($row['salary']);
                $company_name = htmlspecialchars($row['company_name']);
                $job_title = htmlspecialchars($row['job_title']);
                $job_location = htmlspecialchars($row['job_location']);
                $updated = $created_at->diff($now);
                if ($updated->days > 0) {
                    $updated_str = "Updated {$updated->days} days ago";
                } elseif ($updated->h > 0) {
                    $updated_str = "Updated {$updated->h} hours ago";
                } else {
                    $updated_str = "Just updated";
                }
                ?>
                <div class="saved-job-item" id="saved-job-<?php echo $jobid; ?>"
                    style="background: #fff; border-radius: 10px; padding: 18px 18px 18px 0; display: flex; align-items: flex-start; box-shadow: 0 2px 8px #0001; border: 1.5px solid #222;">
                    <a href="jobdetail.php?id=<?php echo $jobid; ?>" style="text-decoration: none; color: inherit; display: flex; flex: 1;">
                        <img src="<?php echo $logo; ?>" alt="job"
                            style="width: 120px; height: 70px; border-radius: 8px; object-fit: cover; margin-right: 18px;">
                        <div style="flex: 1;">
                            <div style="font-weight: bold; font-size: 18px;"><?php echo $job_title; ?></div>
                            <div style="color: #888; font-size: 13px; margin-bottom: 6px;"><?php echo $company_name; ?></div>
                            <div style="display: flex; gap: 10px; margin-bottom: 8px;">
                                <span style="background: #fff; color: #b23b3b; border-radius: 6px; padding: 2px 10px; font-size: 12px;"><?php echo htmlspecialchars($job_location); ?></span>
                                <span style="background: #fff; color: #b23b3b; border-radius: 6px; padding: 2px 10px; font-size: 12px;">
                                    <?php echo $days_left > 0 ? "$days_left days left to apply" : "Application closed"; ?>
                                </span>
                                <span style="background: #fff; color: #888; border-radius: 6px; padding: 2px 10px; font-size: 12px;"><?php echo $updated_str; ?></span>
                            </div>
                            <div style="color: #b23b3b; font-weight: bold; font-size: 15px;"><?php echo $salary; ?></div>
                        </div>
                    </a>
                    <div style="display: flex; flex-direction: column; gap: 8px; margin-left: 18px; align-items: flex-end;">
                        <button class="remove-btn"
                                data-jobid="<?php echo $jobid; ?>"
                                data-jobseekerid="<?php echo $jobseekerid; ?>"
                                style="background: #d90000; color: #fff; border: none; border-radius: 6px; padding: 6px 18px; font-size: 13px; cursor: pointer;">Remove</button>
                    </div>
                </div>

                <?php
                $stmt_job->close(); // Đóng statement cho job sau mỗi lần lặp
            endwhile;
            $stmt_saved->close(); // Đóng statement cho saved_jobs
        } else {
            echo '<div style="color: #888;">No jobseeker selected.</div>';
        }
        ?>
    </div>
</div>