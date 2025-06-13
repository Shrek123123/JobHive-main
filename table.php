<?php
$conn = new mysqli("localhost", "root", "", "");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = $conn;
$conn->query("CREATE DATABASE IF NOT EXISTS jobhive CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$conn->select_db("jobhive");
echo "<p>✔ Database jobhive ready</p>";

// 2. Tạo các bảng cũ (user, profiles, resume, application, feedbacks, company)
$oldTables = [
    "CREATE TABLE IF NOT EXISTS user (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        user_type VARCHAR(30) NOT NULL,
        email VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;",
    "CREATE TABLE IF NOT EXISTS jobseeker_profile (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        jobseeker_id INT UNSIGNED NOT NULL,
        profile_description TEXT NOT NULL,
        profile_pic VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (jobseeker_id) REFERENCES user(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;",
    "CREATE TABLE IF NOT EXISTS employer_profile (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        employer_id INT UNSIGNED NOT NULL,
        company_description TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (employer_id) REFERENCES user(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;",
    "CREATE TABLE IF NOT EXISTS resume (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        jobseeker_id INT UNSIGNED NOT NULL,
        resume_file VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (jobseeker_id) REFERENCES user(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;",
    "CREATE TABLE IF NOT EXISTS application (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        job_id INT UNSIGNED NOT NULL,
        jobseeker_id INT UNSIGNED NOT NULL,
        status ENUM('applied','interviewed','hired','rejected') DEFAULT 'applied',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (job_id) REFERENCES job(id) ON DELETE CASCADE,
        FOREIGN KEY (jobseeker_id) REFERENCES user(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;",
    "CREATE TABLE IF NOT EXISTS jobseekerfeedback (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        jobseeker_id INT UNSIGNED NOT NULL,
        feedback TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (jobseeker_id) REFERENCES user(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;",
    "CREATE TABLE IF NOT EXISTS employerfeedback (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        employer_id INT UNSIGNED NOT NULL,
        feedback TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (employer_id) REFERENCES user(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;",
    "CREATE TABLE IF NOT EXISTS company (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        employer_id INT UNSIGNED NOT NULL,
        company_name VARCHAR(100) NOT NULL,
        company_address VARCHAR(255) NOT NULL,
        industry VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (employer_id) REFERENCES user(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;",
    "CREATE TABLE IF NOT EXISTS job_interest_count (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id INT(6) UNSIGNED NOT NULL,
    interest_count INT(6) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES job(id)
    ) ENGINE=InnoDB;",
];
foreach ($oldTables as $stmt) {
    $conn->query($stmt);
}
echo "<p>✔ Existing tables created/ready</p>";

// 3. Tạo bảng job với tên cột khớp DB cũ (job_title, description, job_location, job_category)
$stmt = $conn->query("CREATE TABLE IF NOT EXISTS job (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    posted_by_employer_id INT UNSIGNED NOT NULL,
    job_title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    company_name VARCHAR(100) NOT NULL,
    job_location VARCHAR(100) NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    company_size VARCHAR(50),
    job_job_title VARCHAR(100) NOT NULL,
    job_description TEXT NOT NULL,
    job_benefit TEXT,
    job_requirement TEXT,
    job_job_location VARCHAR(100) NOT NULL,
    no_employee_needed INT UNSIGNED NOT NULL,
    post_duration INT UNSIGNED NOT NULL,
    contact_email VARCHAR(100) NOT NULL,
    contact_phone VARCHAR(20),
    job_type VARCHAR(50) NOT NULL,
    job_category VARCHAR(100) NOT NULL,
    required_certification VARCHAR(255),
    job_experience VARCHAR(100),
    company_logo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (posted_by_employer_id) REFERENCES user(id) ON DELETE CASCADE
) ENGINE=InnoDB;");
echo "<p>✔ job table ready with legacy columns</p>";

// 4. Thêm các cột mới vào job (nếu chưa có)
$alter = <<<SQL
ALTER TABLE job
  ADD COLUMN IF NOT EXISTS salary_min DECIMAL(10,2) AFTER salary,
  ADD COLUMN IF NOT EXISTS salary_max DECIMAL(10,2) AFTER salary_min,
  ADD COLUMN IF NOT EXISTS experience_level VARCHAR(50) AFTER job_experience,
  ADD COLUMN IF NOT EXISTS remote VARCHAR(20) AFTER experience_level,
  ADD COLUMN IF NOT EXISTS industry VARCHAR(100) AFTER remote,
  ADD COLUMN IF NOT EXISTS application_deadline DATE AFTER created_at,
  ADD Column IF NOT EXISTS required_certification VARCHAR(255) AFTER created_at;
SQL;
$conn->query($alter);
echo "<p>✔ job table updated with new columns</p>";

// 5. Tạo bảng skill và job_skill
$conn->query("CREATE TABLE IF NOT EXISTS skill (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
) ENGINE=InnoDB;");
$conn->query("CREATE TABLE IF NOT EXISTS job_skill (
    job_id INT UNSIGNED NOT NULL,
    skill_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (job_id, skill_id),

    -- jobseeker_id INT UNSIGNED NOT NULL,
    -- status ENUM('applied', 'interviewed', 'hired', 'rejected') DEFAULT 'applied',
    -- fullname VARCHAR(100) NOT NULL,
    -- phonenumber VARCHAR(20) NOT NULL,
    -- email VARCHAR(100) NOT NULL,
    -- created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- cv_file VARCHAR(255),
    -- allow_search BOOLEAN DEFAULT FALSE,
    -- UNIQUE (job_id, jobseeker_id),

    FOREIGN KEY (job_id) REFERENCES job(id) ON DELETE CASCADE,
    FOREIGN KEY (skill_id) REFERENCES skill(id) ON DELETE CASCADE
) ENGINE=InnoDB;");
echo "<p>✔ skill & job_skill tables ready</p>";

// 6. (Tuỳ chọn) Chèn sample data
$skills = ['HTML', 'PHP', 'JavaScript', 'MySQL', 'Linux'];
foreach ($skills as $s) {
    $conn->query("INSERT IGNORE INTO skill (name) VALUES ('" . $conn->real_escape_string($s) . "')");
    $conn->query("INSERT IGNORE INTO job_skill (job_id,skill_id) SELECT 1, id FROM skill WHERE name='" . $conn->real_escape_string($s) . "'");
}
// 7. Chèn sample job data (no NULL fields)
// <<<SQL gọi là heredoc trong PHP là 1 cách để đỡ phải xuống dòng or truy vấn nhiều lần khi thực thi add thêm or insert
$insertJobs = <<<SQL
INSERT INTO job (
    job_job_title, description, company_name, job_location, salary,
    salary_min, salary_max, industry, experience_level,
    job_type, remote, job_category, posted_date, created_at,
    required_certification, application_deadline
) VALUES
  ('Junior JAva Developer', 'Looking for an entry-level PHP dev.', 'TechCorp', 'Hanoi', 800.00,
   700.00, 900.00, 'Software', 'Entry Level', 'Full-time', 'Onsite', 'IT', '2025-05-13', '2025-05-13 12:26:13',
   'Bachelor of Computer Science', '2025-06-30'),
  ('Marketing Intern', 'Assist our marketing team in digital campaigns.', 'MarketingMax', 'Ho Chi Minh', 500.00,
   450.00, 550.00, 'Advertising', 'Intern', 'Internship', 'Onsite', 'Marketing', '2025-05-13', '2025-05-13 12:26:13',
   'Diploma in Marketing', '2025-07-15'),
  ('Junior Backend Engineer', 'Develop scalable backend services.', 'BigData Inc', 'Remote', 2000.00,
   1000.00, 1200.00, 'Technology', 'Junior Level', 'Full-time', 'Remote', 'IT', '2025-05-13', '2025-05-13 12:26:13',
   'Master of Engineering', '2025-06-20')
ON DUPLICATE KEY UPDATE
  job_title=VALUES(job_title), salary=VALUES(salary);
SQL;
$conn->query($insertJobs);
echo "<h3>🎉 Sample job data inserted</h3>";

// Tạo bảng jobseekerfeedback
$stmt = $conn->query("CREATE TABLE IF NOT EXISTS jobseekerfeedback (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jobseeker_id INT UNSIGNED NOT NULL,
    feedback TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (jobseeker_id) REFERENCES user(id) ON DELETE CASCADE
)");
if ($stmt === TRUE) {
    echo "Table jobseekerfeedback created successfully <br>";
} else {
    echo "Error creating table: " . $conn->error;
}
// =======
// // Tạo bảng employerfeedback
// $stmt = $conn->query("CREATE TABLE IF NOT EXISTS employerfeedback (
//     id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     employer_id INT UNSIGNED NOT NULL,
//     feedback TEXT NOT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (employer_id) REFERENCES user(id) ON DELETE CASCADE
// )");
// if ($stmt === TRUE) {
//     echo "Table employerfeedback created successfully <br>";
// } else {
//     echo "Error creating table: " . $conn->error;
// }

// // Tạo bảng company
// $stmt = $conn->query("CREATE TABLE IF NOT EXISTS company (
//     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     employer_id INT(6) UNSIGNED NOT NULL,
//     company_name VARCHAR(100) NOT NULL,
//     company_address VARCHAR(255) NOT NULL,
//     industry VARCHAR(100) NOT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (employer_id) REFERENCES user(id)
// )");
// if ($stmt === TRUE) {
//     echo "Table company created successfully <br>";
// } else {
//     echo "Error creating table: " . $conn->error;
// }

// $stmt = $conn->query("CREATE TABLE IF NOT EXISTS job_interest_count (
//     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     job_id INT(6) UNSIGNED NOT NULL,
//     interest_count INT(6) DEFAULT 0,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (job_id) REFERENCES job(id)
// )");
// if ($stmt === TRUE) {
//     echo "Table job_interest_count created successfully <br>";
// } else {
//     echo "Error creating table: " . $conn->error;
// }

// // Chèn dữ liệu mẫu vào bảng user

// $stmt = $conn->query("INSERT INTO user (username, user_type, email, password) VALUES
// ('admin', 'admin', 'admin@jobhive.com', 'admin123'),
// ('employer_abc', 'employer', 'abc@company.com', 'password123'),
// ('employer_xyz', 'employer', 'xyz@company.com', 'password123'),
// ('jobseeker_anh', 'jobseeker', 'anh@gmail.com', 'password123'),
// ('jobseeker_binh', 'jobseeker', 'binh@gmail.com', 'password123')

// ");
// if ($stmt === TRUE) {
//     echo "Sample data inserted into user table successfully <br>";
// } else {
//     echo "Error inserting sample data: " . $conn->error;
// }

// // Chèn dữ liệu mẫu vào bảng employer_profile
// $stmt = $conn->query("INSERT INTO employer_profile (employer_id, company_description, profile_pic) VALUES
// (1, 'Leading tech company in Vietnam.', 'abc_logo.png'),
// (2, 'Creative agency specializing in branding.', 'xyz_logo.png')");
// if ($stmt === TRUE) {
//     echo "Sample data inserted into employer_profile table successfully <br>";
// } else {
//     echo "Error inserting sample data: " . $conn->error;
// }

// // Chèn dữ liệu mẫu vào bảng company
// $stmt = $conn->query("INSERT INTO company (employer_id, company_name, company_address, industry) VALUES
// (1, 'ABC Corp', '123 Tran Hung Dao, Hanoi', 'Information Technology'),
// (2, 'XYZ Ltd', '456 Nguyen Trai, Ho Chi Minh City', 'Design & Marketing')");
// if ($stmt === TRUE) {
//     echo "Sample data inserted into company table successfully <br>";
// } else {
//     echo "Error inserting sample data: " . $conn->error;
// }

// // Chèn dữ liệu mẫu vào bảng jobseeker_profile
// $stmt = $conn->query("INSERT INTO jobseeker_profile (jobseeker_id, profile_description, profile_pic) VALUES
// (3, 'Experienced frontend developer.', 'anh_profile.jpg'),
// (4, 'Creative designer with passion for UX.', 'binh_profile.jpg')");
// if ($stmt === TRUE) {
//     echo "Sample data inserted into jobseeker_profile table successfully <br>";
// } else {
//     echo "Error inserting sample data: " . $conn->error;
// }

// // Chèn dữ liệu mẫu vào bảng resume
// $stmt = $conn->query("INSERT INTO resume (jobseeker_id, resume_file) VALUES
// (3, 'resume_anh.pdf'),
// (4, 'resume_binh.pdf')");
// if ($stmt === TRUE) {
//     echo "Sample data inserted into resume table successfully <br>";
// } else {
//     echo "Error inserting sample data: " . $conn->error;
// }

// Chèn dữ liệu mẫu vào bảng job
$stmt = $conn->query("INSERT INTO job (posted_by_employer_id, company_name, job_job_title, job_description, job_job_location, salary, contact_email, contact_phone, job_type, job_job_category, required_certification, job_experience, company_logo) VALUES 
    (1, 'ABC Corp', 'Web Developer', 'Develop and maintain web applications.', 'Hanoi', 1500.00, 'hr@abccorp.com', '0123456789', 'Full-time', 'IT', 'Bachelor of IT', '2 years', 'logo1.jpg'),
    (1, 'XYZ Ltd', 'Graphic Designer', 'Design marketing materials and branding.', 'Ho Chi Minh City', 1200.00, 'jobs@xyzltd.com', '0987654321', 'Part-time', 'Design', 'Bachelor of Design', '1 year', 'logo2.jpg'),
    (2, 'Tech Solutions', 'System Analyst', 'Analyze and improve IT systems.', 'Da Nang', 2000.00, 'careers@techsolutions.com', '0112233445', 'Full-time', 'IT', 'Bachelor of Computer Science', '3 years', 'logo3.jpg'),
    (2, 'NextGen Co', 'DevOps Engineer', 'Maintain deployment pipelines and cloud infrastructure.', 'Can Tho', 1800.00, 'devops@nextgen.com', '0998877665', 'Full-time', 'IT', 'Bachelor of IT', '3 years', 'logo4.jpg'),
    (1, 'Creative Minds', 'Content Writer', 'Write blog articles and web content.', 'Hanoi', 1000.00, 'content@creativeminds.com', '0887766554', 'Remote', 'Marketing', 'Bachelor of Journalism', '1 year', 'logo5.jpg')
");
if ($stmt === TRUE) {
    echo "Sample data inserted into job table successfully <br>";
} else {
    echo "Error inserting sample data: " . $conn->error;
}

// Chèn dữ liệu mẫu vào bảng application
$stmt = $conn->query("INSERT INTO application (job_id, jobseeker_id, status) VALUES
(1, 3, 'applied'),
(2, 4, 'interviewed'),
(3, 3, 'hired')");
if ($stmt === TRUE) {
    echo "Sample data inserted into application table successfully <br>";
} else {
    echo "Error inserting sample data: " . $conn->error;
}

// Chèn dữ liệu mẫu vào bảng job_interest_count
$stmt = $conn->query("INSERT INTO job_interest_count (job_id, interest_count) VALUES
(1, 15),
(2, 8),
(3, 12)");
if ($stmt === TRUE) {
    echo "Sample data inserted into job_interest_count table successfully <br>";
} else {
    echo "Error inserting sample data: " . $conn->error;
}

// Chèn dữ liệu mẫu vào bảng jobseekerfeedback
$stmt = $conn->query("INSERT INTO jobseekerfeedback (jobseeker_id, feedback) VALUES
(3, 'Great platform for job search!'),
(4, 'Easy to use and helpful.')");
if ($stmt === TRUE) {
    echo "Sample data inserted into jobseekerfeedback table successfully <br>";
} else {
    echo "Error inserting sample data: " . $conn->error;
}

// Chèn dữ liệu mẫu vào bảng employerfeedback
$stmt = $conn->query("INSERT INTO employerfeedback (employer_id, feedback) VALUES
(1, 'Received many quality applications.'),
(2, 'Would love to see more job categories.')");
if ($stmt === TRUE) {
    echo "Sample data inserted into employerfeedback table successfully <br>";
} else {
    echo "Error inserting sample data: " . $conn->error;
}
