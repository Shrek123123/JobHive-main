<?php
// Kết nối đến MySQL để tạo cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $sql->connect_error);
}

// Tạo cơ sở dữ liệu jobhive nếu chưa tồn tại
$conn->query("CREATE DATABASE IF NOT EXISTS jobhive");

// Chọn cơ sở dữ liệu jobhive
$conn->select_db("jobhive");

// Tạo bảng user
$sql = "CREATE TABLE IF NOT EXISTS user (
<<<<<<< Updated upstream
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'employer', 'applicant') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Table 'user' created successfully.<br>" : "Error creating 'user': " . $conn->error . "<br>";

// Tạo bảng company
$sql = "CREATE TABLE IF NOT EXISTS company (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
<<<<<<< Updated upstream
    jobseeker_id INT UNSIGNED NOT NULL,
    profile_description TEXT NOT NULL,
    profile_pic VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (jobseeker_id) REFERENCES user(id) ON DELETE CASCADE
)");
if ($stmt === TRUE) {
    echo "Table jobseeker_profile created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}

// Tạo bảng employer_profile
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS employer_profile (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employer_id INT UNSIGNED NOT NULL,
    company_description TEXT NOT NULL,
    profile_pic VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employer_id) REFERENCES user(id) ON DELETE CASCADE
)");
if ($stmt === TRUE) {
    echo "Table employer_profile created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}
=======
=======
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'employer', 'applicant') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Table 'user' created successfully.<br>" : "Error creating 'user': " . $conn->error . "<br>";

// Tạo bảng company
$sql = "CREATE TABLE IF NOT EXISTS company (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
>>>>>>> Stashed changes
    name VARCHAR(100) NOT NULL,
    address TEXT,
    website VARCHAR(255),
    logo VARCHAR(255),
    created_by_user_id INT UNSIGNED,
    FOREIGN KEY (created_by_user_id) REFERENCES user(id) ON DELETE CASCADE
)";
$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Table 'company' created successfully.<br>" : "Error creating 'company': " . $conn->error . "<br>";
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes

// Tạo bảng job
$sql = "CREATE TABLE IF NOT EXISTS job (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    posted_by_employer_id INT UNSIGNED NOT NULL,
    company_name VARCHAR(100) NOT NULL,
    job_title VARCHAR(100) NOT NULL,
    job_description TEXT NOT NULL,
    job_location VARCHAR(100) NOT NULL,
    salary VARCHAR(30) NOT NULL,
    post_duration INT UNSIGNED NOT NULL,
    contact_email VARCHAR(100) NOT NULL,
    contact_phone VARCHAR(20),
    job_type VARCHAR(50) NOT NULL,
    job_remote VARCHAR(50) NOT NULL,
    job_category VARCHAR(100) NOT NULL,
    required_certification VARCHAR(255),
    job_experience VARCHAR(100),
    company_logo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (posted_by_employer_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE
)";
$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Table 'job' created successfully.<br>" : "Error creating 'job': " . $conn->error . "<br>";

// Tạo bảng resume
$sql = "CREATE TABLE IF NOT EXISTS resume (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    applicant_id INT UNSIGNED,
    resume_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (applicant_id) REFERENCES user(id) ON DELETE CASCADE
)";
$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Table 'resume' created successfully.<br>" : "Error creating 'resume': " . $conn->error . "<br>";

// Tạo bảng application
$sql = "CREATE TABLE IF NOT EXISTS application (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id INT UNSIGNED,
    applicant_id INT UNSIGNED,
    resume_id INT UNSIGNED,
    cover_letter TEXT,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES job(id) ON DELETE CASCADE,
    FOREIGN KEY (applicant_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (resume_id) REFERENCES resume(id) ON DELETE SET NULL
)";
$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Table 'application' created successfully.<br>" : "Error creating 'application': " . $conn->error . "<br>";

// Tạo bảng feedback
$sql = "CREATE TABLE IF NOT EXISTS feedback (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED,
    message TEXT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
)";
$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Table 'feedback' created successfully.<br>" : "Error creating 'feedback': " . $conn->error . "<br>";

// Tạo bảng skill
$sql = "CREATE TABLE IF NOT EXISTS skill (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
<<<<<<< Updated upstream
<<<<<<< Updated upstream
    employer_id INT UNSIGNED NOT NULL,
    feedback TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employer_id) REFERENCES user(id) ON DELETE CASCADE
)");
if ($stmt === TRUE) {
    echo "Table employerfeedback created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}

// Tạo bảng company
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS company (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employer_id INT(6) UNSIGNED NOT NULL,
    company_name VARCHAR(100) NOT NULL,
    company_address VARCHAR(255) NOT NULL,
    industry VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employer_id) REFERENCES user(id)
)");
if ($stmt === TRUE) {
    echo "Table company created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}

// Chèn dữ liệu mẫu vào bảng job
$stmt = $sql->query("INSERT INTO job (posted_by_employer_id, company_name, job_title, job_description, job_location, salary, contact_email, contact_phone, job_type, job_category, required_certification, job_experience, company_logo) VALUES 
    (1, 'ABC Corp', 'Web Developer', 'Develop and maintain web applications.', 'Hanoi', 1500.00, 'hr@abccorp.com', '0123456789', 'Full-time', 'IT', 'Bachelor of IT', '2 years', 'logo1.png'),
    (1, 'XYZ Ltd', 'Graphic Designer', 'Design marketing materials and branding.', 'Ho Chi Minh City', 1200.00, 'jobs@xyzltd.com', '0987654321', 'Part-time', 'Design', 'Bachelor of Design', '1 year', 'logo2.png'),
    (2, 'Tech Solutions', 'System Analyst', 'Analyze and improve IT systems.', 'Da Nang', 2000.00, 'careers@techsolutions.com', '0112233445', 'Full-time', 'IT', 'Bachelor of Computer Science', '3 years', 'logo3.png')
");
if ($stmt === TRUE) {
    echo "Sample data inserted into job table successfully <br>";
} else {
    echo "Error inserting sample data: " . $sql->error;
}
=======
=======
>>>>>>> Stashed changes
    name VARCHAR(100) NOT NULL UNIQUE
)";
$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Table 'skill' created successfully.<br>" : "Error creating 'skill': " . $conn->error . "<br>";

// Tạo bảng job_skill
$sql = "CREATE TABLE IF NOT EXISTS job_skill (
    job_id INT UNSIGNED,
    skill_id INT UNSIGNED,
    PRIMARY KEY (job_id, skill_id),
    FOREIGN KEY (job_id) REFERENCES job(id) ON DELETE CASCADE,
    FOREIGN KEY (skill_id) REFERENCES skill(id) ON DELETE CASCADE
)";
$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Table 'job_skill' created successfully.<br>" : "Error creating 'job_skill': " . $conn->error . "<br>";

// Thêm dữ liệu mẫu vào các bảng đã tạo
// 1. Thêm user
$sql = "INSERT INTO user (username, password, email, role) VALUES
('admin1', '123456', 'admin1@example.com', 'admin'),
('employer1', '123456', 'employer1@example.com', 'employer'),
('applicant1', '123456', 'applicant1@example.com', 'applicant')";
$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Inserted sample users.<br>" : "Error inserting users: " . $conn->error . "<br>";

// 2. Thêm company (gắn với employer1 có id = 2)
$sql = "INSERT INTO company (name, address, website, logo, created_by_user_id) VALUES
('TechCorp', '123 Street, City', 'https://techcorp.com', 'logo.png', 2)";
$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Inserted sample company.<br>" : "Error inserting company: " . $conn->error . "<br>";

// 3. Thêm job (gắn với employer1 có id = 2)
$sql = "INSERT INTO job (
    posted_by_employer_id, company_name, job_title, job_description,
    job_location, salary, contact_email, contact_phone,
    job_type, job_remote, job_category, required_certification, job_experience,
    company_logo
) VALUES
(2, 'Tech Solutions', 'Backend Developer', 'Phát triển hệ thống web với PHP và MySQL.', 'Hà Nội', 1500.00, 'hr@techsolutions.vn', '0123456789', 'Toàn thời gian', 'Onsite', 'CNTT', 'PHP, MySQL', '2 năm kinh nghiệm', 'logo1.jpg'),
(2, 'Digital Works', 'Mobile App Developer', 'Xây dựng ứng dụng iOS và Android.', 'TP.HCM', 1800.00, 'jobs@digitalworks.com', '0933221122', 'Toàn thời gian', 'Remote', 'Mobile', 'Flutter hoặc React Native', '3 năm', 'logo2.jpg'),
(2, 'DataCorp', 'Data Analyst', 'Phân tích dữ liệu và lập báo cáo thống kê.', 'Đà Nẵng', 1700.00, 'apply@datacorp.vn', NULL, 'Bán thời gian', 'OnSite', 'Phân tích dữ liệu', 'SQL, Excel nâng cao', '1 năm', 'logo3.jpg'),
(2, 'SecureNet', 'System Administrator', 'Quản trị hệ thống mạng và máy chủ.', 'Hải Phòng', 1600.00, 'admin@securenet.vn', '0909888777', 'Toàn thời gian', 'OnSite', 'Hệ thống', 'Linux, CCNA', '3 năm trở lên', 'logo4.jpg'),
(2, 'BrightSoft', 'Frontend Developer', 'Thiết kế giao diện người dùng bằng HTML, CSS, JS.', 'Cần Thơ', 1400.00, 'frontend@brightsoft.vn', '0987654321', 'Thực tập', 'Remote', 'Web Development', 'Không yêu cầu', 'Không yêu cầu', 'logo5.jpg')";

$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Inserted sample job.<br>" : "Error inserting job: " . $conn->error . "<br>";

// 4. Thêm resume cho applicant1 có id = 3
$sql = "INSERT INTO resume (applicant_id, resume_path) VALUES (3, 'uploads/resume1.pdf')";
$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Inserted sample resume.<br>" : "Error inserting resume: " . $conn->error . "<br>";

// 5. Thêm skills
$sql = "INSERT INTO skill (name) VALUES ('PHP'), ('MySQL'), ('Laravel')";
$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Inserted sample skills.<br>" : "Error inserting skills: " . $conn->error . "<br>";

// 6. Gán kỹ năng cho job (job id = 1)
$sql = "INSERT INTO job_skill (job_id, skill_id) VALUES (1, 1), (1, 2)";
$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Inserted job_skill mappings.<br>" : "Error inserting job_skill: " . $conn->error . "<br>";

// 7. Thêm application (ứng viên 3 apply job 1 với resume 1)
$sql = "INSERT INTO application (job_id, applicant_id, resume_id, cover_letter)
VALUES (1, 3, 1, 'I am very interested in this job.')";
$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Inserted sample application.<br>" : "Error inserting application: " . $conn->error . "<br>";

// 8. Thêm feedback từ user
$sql = "INSERT INTO feedback (user_id, message) VALUES (3, 'Great platform!')";
$stmt = $conn->query($sql);
echo $stmt === TRUE ? "Inserted sample feedback.<br>" : "Error inserting feedback: " . $conn->error . "<br>";
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes


$conn->close();
