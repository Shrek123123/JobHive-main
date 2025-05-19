<?php
// Kết nối đến MySQL để tạo cơ sở dữ liệu
$sql = new mysqli("localhost", "root", "", "");

// Kiểm tra kết nối
if ($sql->connect_error) {
    die("Connection failed: " . $sql->connect_error);
}

// Tạo cơ sở dữ liệu jobhive nếu chưa tồn tại
$sql->query("CREATE DATABASE IF NOT EXISTS jobhive");

// Chọn cơ sở dữ liệu jobhive
$sql->select_db("jobhive");

// Tạo bảng user
$sql->query("CREATE TABLE IF NOT EXISTS user (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,

    user_type ENUM('jobseeker', 'employer', 'admin') NOT NULL DEFAULT 'jobseeker',
    email VARCHAR(50) NOT NULL UNIQUE,

    -- user_type VARCHAR(30) NOT NULL,
    -- email VARCHAR(50) NOT NULL,

    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Tạo bảng jobseeker_profile
$sql->query("CREATE TABLE IF NOT EXISTS jobseeker_profile (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jobseeker_id INT UNSIGNED NOT NULL,
    profile_description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (jobseeker_id) REFERENCES user(id) ON DELETE CASCADE
)");

// Tạo bảng employer_profile
$sql->query("CREATE TABLE IF NOT EXISTS employer_profile (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employer_id INT UNSIGNED NOT NULL,
    company_description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employer_id) REFERENCES user(id) ON DELETE CASCADE
)");

// Tạo bảng job
$sql->query("CREATE TABLE IF NOT EXISTS job (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    company_name VARCHAR(100) NOT NULL,
    location VARCHAR(100) NOT NULL,
    salary INT NOT NULL,
    industry VARCHAR(50),
    experience_level ENUM('internship', 'entry', 'mid', 'senior') DEFAULT 'entry',
    job_type ENUM('full-time', 'part-time', 'internship', 'contract') DEFAULT 'full-time',
    remote ENUM('remote', 'onsite') DEFAULT 'onsite',
    category VARCHAR(50),
    posted_date DATE DEFAULT CURRENT_DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Tạo bảng resume
$sql->query("CREATE TABLE IF NOT EXISTS resume (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jobseeker_id INT UNSIGNED NOT NULL,
    resume_file VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (jobseeker_id) REFERENCES user(id) ON DELETE CASCADE
)");

// Tạo bảng application
$sql->query("CREATE TABLE IF NOT EXISTS application (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id INT UNSIGNED NOT NULL,
    jobseeker_id INT UNSIGNED NOT NULL,
    status ENUM('applied', 'interviewed', 'hired', 'rejected') DEFAULT 'applied',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES job(id) ON DELETE CASCADE,
    FOREIGN KEY (jobseeker_id) REFERENCES user(id) ON DELETE CASCADE
)");

// Tạo bảng jobseekerfeedback
$sql->query("CREATE TABLE IF NOT EXISTS jobseekerfeedback (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jobseeker_id INT UNSIGNED NOT NULL,
    feedback TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (jobseeker_id) REFERENCES user(id) ON DELETE CASCADE
)");

// Tạo bảng employerfeedback
$sql->query("CREATE TABLE IF NOT EXISTS employerfeedback (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employer_id INT UNSIGNED NOT NULL,
    feedback TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employer_id) REFERENCES user(id) ON DELETE CASCADE
)");

$sql->query("CREATE TABLE IF NOT EXISTS application (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id INT UNSIGNED NOT NULL,
    jobseeker_id INT UNSIGNED NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    cv_path VARCHAR(255),
    allow_search BOOLEAN DEFAULT 0,
    status ENUM('applied', 'interviewed', 'hired', 'rejected') DEFAULT 'applied',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    -- Khóa ngoại liên kết với bảng job và user
    FOREIGN KEY (job_id) REFERENCES job(id) ON DELETE CASCADE,
    FOREIGN KEY (jobseeker_id) REFERENCES user(id) ON DELETE CASCADE
)");

echo "✅ All tables created successfully!";

// Chèn dữ liệu mẫu vào bảng job
$sql->query("INSERT INTO job (title, description, company_name, location, salary, category, experience_level, job_type, remote, industry, created_at)
VALUES
('Junior PHP Developer', 'Looking for an entry-level PHP dev.', 'TechCorp', 'Hanoi', 800, 'IT', 'entry', 'full-time', 'onsite', 'Software', NOW()),
('Marketing Intern', 'Internship for social media marketing.', 'MarketingMax', 'Ho Chi Minh', 500, 'Marketing', 'entry', 'internship', 'onsite', 'Advertising', NOW()),
('Senior Backend Engineer', 'Develop scalable backend services.', 'BigData Inc', 'Remote', 2000, 'IT', 'senior', 'full-time', 'remote', 'Technology', NOW());
");

if ($stmt === TRUE) {
    echo "Table employerfeedback created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}

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
?>



