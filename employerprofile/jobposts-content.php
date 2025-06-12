<?php
require_once '../config.php';
?>
<div style="padding: 30px;">
    <h2 style="color: #b23b3b; margin-bottom: 20px;">My Job Posts</h2>
    <div style="display: flex; flex-direction: column; gap: 18px;">
        <?php
        // Get employer id from URL (?id=...)
        $employer_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // If no employer id, do not query
        if ($employer_id > 0) {
            // Query job posts of this employer
            $sql = "SELECT * FROM job WHERE posted_by_employer_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $employer_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                echo '<div style="color: #888;">No job posts found.</div>';
            }

            while ($row = $result->fetch_assoc()):
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
        <div
            style="background: #f3f3f3; border-radius: 10px; padding: 18px 18px 18px 0; display: flex; align-items: flex-start; box-shadow: 0 2px 8px #0001;">
            <img src="<?php echo $logo; ?>"
                alt="job"
                style="width: 120px; height: 70px; border-radius: 8px; object-fit: cover; margin-right: 18px;">
            <div style="flex: 1;">
                <div style="font-weight: bold; font-size: 18px;"><?php echo $job_title; ?></div>
                <div style="color: #888; font-size: 13px; margin-bottom: 6px;"><?php echo $company_name; ?></div>
                <div style="display: flex; gap: 10px; margin-bottom: 8px;">
                    <span
                        style="background: #fff; color: #b23b3b; border-radius: 6px; padding: 2px 10px; font-size: 12px;"><?php echo htmlspecialchars($job_location); ?></span>
                    <span
                        style="background: #fff; color: #b23b3b; border-radius: 6px; padding: 2px 10px; font-size: 12px;">
                        <?php echo $days_left > 0 ? "$days_left days left to apply" : "Application closed"; ?>
                    </span>
                    <span
                        style="background: #fff; color: #888; border-radius: 6px; padding: 2px 10px; font-size: 12px;"><?php echo $updated_str; ?></span>
                </div>
                <div style="color: #b23b3b; font-weight: bold; font-size: 15px;"><?php echo $salary; ?></div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 8px; margin-left: 18px; align-items: flex-end;">
                <button
                    style="background: #d90000; color: #fff; border: none; border-radius: 6px; padding: 6px 18px; font-size: 13px; cursor: pointer;">Edit</button>
                <button
                    style="background: #fff; color: #d90000; border: 1px solid #d90000; border-radius: 6px; padding: 6px 18px; font-size: 13px; cursor: pointer;">Delete</button>
                <button
                    style="background: #b23b3b; color: #fff; border: none; border-radius: 6px; padding: 6px 18px; font-size: 13px; cursor: pointer;">Check submitted applications</button>
            </div>
        </div>
        <?php endwhile;
        } else {
            echo '<div style="color: #888;">No employer selected.</div>';
        }
        ?>
    </div>
</div>