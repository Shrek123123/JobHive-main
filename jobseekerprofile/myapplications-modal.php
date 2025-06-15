<?php
// jobseekerprofile/myapplications-modal.php
require_once '../config.php'; // Đảm bảo đường dẫn đến config.php là đúng

// Lấy jobseeker_id từ URL của Ajax request
$jobseeker_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($jobseeker_id <= 0) {
    echo '<div style="padding: 30px; text-align: center; color: #d90000;">Invalid Jobseeker ID.</div>';
    exit;
}
?>

<div style="padding: 30px;">
    <h2 style="color: #b23b3b; margin-bottom: 20px;">My Applications</h2>
    <div style="display: flex; flex-direction: column; gap: 20px;">
        <?php
        if (isset($conn) && $conn->ping()) {
            $sql = "SELECT 
                        a.id AS application_id,
                        a.created_at AS application_created_at, -- Đổi tên cột để dễ phân biệt
                        a.status AS application_status,
                        a.fullname,
                        a.email,
                        a.phonenumber,
                        a.cv_file,
                        j.job_title,
                        j.company_name,
                        j.job_location,
                        j.id AS job_id
                    FROM 
                        application a
                    JOIN 
                        job j ON a.job_id = j.id
                    WHERE 
                        a.jobseeker_id = ?
                    ORDER BY 
                        a.created_at DESC";

            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("i", $jobseeker_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 0) {
                    echo '<div style="color: #888; text-align: center; padding: 20px;">You haven\'t submitted any applications yet.</div>';
                } else {
                    $counter = 0; // Để đếm số thứ tự ứng tuyển
                    while ($row = $result->fetch_assoc()):
                        $counter++;
                        $app_id = htmlspecialchars($row['application_id']);
                        // Lấy thời gian nộp đơn từ cột application_created_at
                        $application_submitted_datetime = new DateTime($row['application_created_at']);
                        $submitted_time_full = $application_submitted_datetime->format('d/m/Y H:i'); // Ví dụ: 15/06/2025 10:44
                        $submitted_date_only = $application_submitted_datetime->format('d/m/Y'); // Ví dụ: 15/06/2025

                        $job_title = htmlspecialchars($row['job_title']);
                        $company_name = htmlspecialchars($row['company_name']);
                        $job_location = htmlspecialchars($row['job_location']);
                        $job_id = htmlspecialchars($row['job_id']);
                        $app_status = htmlspecialchars($row['application_status']);
                        $fullname = htmlspecialchars($row['fullname']);
                        $email = htmlspecialchars($row['email']);
                        $phonenumber = htmlspecialchars($row['phonenumber']);
                        $cv_file = !empty($row['cv_file']) ? htmlspecialchars($row['cv_file']) : '#'; // Link đến CV
                        
                        // Định nghĩa trạng thái và màu sắc/biểu tượng
                        $display_status = '';
                        $status_color = '#6c757d'; // Default grey
                        switch ($app_status) {
                            case 'pending':
                                $display_status = '⏳ Pending Response';
                                $status_color = '#ffc107'; // Yellow
                                break;
                            case 'interviewed':
                                $display_status = '✅ Interviewed';
                                $status_color = '#007bff'; // Blue
                                break;
                            case 'hired':
                                $display_status = '🎉 Hired';
                                $status_color = '#28a745'; // Green
                                break;
                            case 'rejected':
                                $display_status = '❌ Rejected';
                                $status_color = '#dc3545'; // Red
                                break;
                            default:
                                $display_status = '❓ Unknown Status';
                                $status_color = '#6c757d';
                                break;
                        }
                    ?>
                        <div class="application-card" style="background: #fdfdfd; border: 1px solid #eee; border-left: 5px solid #b23b3b; border-radius: 8px; padding: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                            <div style="font-size: 1.1em; font-weight: bold; color: #b23b3b; margin-bottom: 10px;">
                                📝 Application #<?php echo $counter; ?> (at <?php echo $submitted_time_full; ?>)
                            </div>
                            <div style="margin-bottom: 5px;">
                                💼 Job: 
                                <a href="jobdetail.php?id=<?php echo $job_id; ?>" style="color: #007bff; text-decoration: none; font-weight: bold;">
                                    <?php echo $job_title; ?> at <?php echo $company_name; ?> in <?php echo $job_location; ?>
                                </a>
                            </div>
                            <div style="margin-bottom: 5px;">📅 Submitted on: <?php echo $submitted_date_only; ?></div>
                            <div style="margin-bottom: 5px;">
                                📄 CV Submitted: 
                                <?php if ($cv_file != '#'): ?>
                                    <a href="<?php echo $cv_file; ?>" target="_blank" style="color: #007bff; text-decoration: none;">[View Details]</a>
                                <?php else: ?>
                                    <span>[N/A]</span>
                                <?php endif; ?>
                            </div>
                            <div style="margin-bottom: 5px;">
                                📌 Status: <span style="font-weight: bold; color: <?php echo $status_color; ?>;"><?php echo $display_status; ?></span>
                            </div>
                            <div style="margin-bottom: 5px;">👤 Name: <?php echo $fullname; ?></div>
                            <div style="margin-bottom: 5px;">✉️ Email: <?php echo $email; ?></div>
                            <div>📞 Phone Number: <?php echo $phonenumber; ?></div>
                        </div>
                    <?php
                    endwhile;
                }
                $stmt->close();
            } else {
                echo '<div style="padding: 30px; text-align: center; color: #d90000;">Error preparing query: ' . $conn->error . '</div>';
            }
            $conn->close(); // Đóng kết nối sau khi hoàn tất
        } else {
            echo '<div style="padding: 30px; text-align: center; color: #d90000;">Database connection error.</div>';
        }
        ?>
    </div>
</div>