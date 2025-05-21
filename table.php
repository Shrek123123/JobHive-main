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
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS user (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    user_type VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
if ($stmt === TRUE) {
    echo "Table user created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}

// Tạo bảng jobseeker_profile
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS jobseeker_profile (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jobseeker_id INT UNSIGNED NOT NULL,
    profile_description TEXT NOT NULL,
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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employer_id) REFERENCES user(id) ON DELETE CASCADE
)");
if ($stmt === TRUE) {
    echo "Table employer_profile created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}

// Tạo bảng job
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS job (
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
    posted_by_employer_id INT UNSIGNED NOT NULL,
    company_name VARCHAR(100) NOT NULL,
    job_title VARCHAR(100) NOT NULL,
    job_description TEXT NOT NULL,
    job_location VARCHAR(100) NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    contact_email VARCHAR(100) NOT NULL,
    contact_phone VARCHAR(20),
    job_type VARCHAR(50) NOT NULL,
    job_category VARCHAR(100) NOT NULL,
    required_certification VARCHAR(255),
    job_experience VARCHAR(100),
    company_logo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (posted_by_employer_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE
)");
if ($stmt === TRUE) {
    echo "Table job created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}

// Tạo bảng resume
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS resume (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jobseeker_id INT UNSIGNED NOT NULL,
    resume_file VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (jobseeker_id) REFERENCES user(id) ON DELETE CASCADE
)");
if ($stmt === TRUE) {
    echo "Table resume created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}

// Tạo bảng application
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS application (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id INT UNSIGNED NOT NULL,
    jobseeker_id INT UNSIGNED NOT NULL,
    status ENUM('applied', 'interviewed', 'hired', 'rejected') DEFAULT 'applied',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES job(id) ON DELETE CASCADE,
    FOREIGN KEY (jobseeker_id) REFERENCES user(id) ON DELETE CASCADE
)");
if ($stmt === TRUE) {
    echo "Table application created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}

// Tạo bảng jobseekerfeedback
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS jobseekerfeedback (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jobseeker_id INT UNSIGNED NOT NULL,
    feedback TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (jobseeker_id) REFERENCES user(id) ON DELETE CASCADE
)");
if ($stmt === TRUE) {
    echo "Table jobseekerfeedback created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}

// Tạo bảng employerfeedback
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS employerfeedback (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
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
$stmt = $sql->query("INSERT INTO job (title, description, company_name, location, salary, category, experience_level, job_type, remote, industry, created_at)
VALUES
('Junior PHP Developer', 'Looking for an entry-level PHP dev.', 'TechCorp', 'Hanoi', 800, 'IT', 'entry', 'full-time', 'onsite', 'Software', NOW()),
('Marketing Intern', 'Internship for social media marketing.', 'MarketingMax', 'Ho Chi Minh', 500, 'Marketing', 'entry', 'internship', 'onsite', 'Advertising', NOW()),
('Senior Backend Engineer', 'Develop scalable backend services.', 'BigData Inc', 'Remote', 2000, 'IT', 'senior', 'full-time', 'remote', 'Technology', NOW());
");
if ($stmt === TRUE) {
    echo "Sample data inserted into job table successfully <br>";
} else {
    echo "Error inserting sample data: " . $sql->error;
}
?>


