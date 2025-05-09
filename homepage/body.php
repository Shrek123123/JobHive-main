<ul>
        <?php
        // Fetch jobs from the database
        $result = $sql->query("SELECT * FROM jobs");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row['job_title'] . " - " . $row['company_name'] . "</li>";
            }
        } else {
            echo "<li>No jobs available at the moment.</li>";
        }

        ?>
    </ul>