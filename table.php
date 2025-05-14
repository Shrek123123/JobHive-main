<?php
$sql = new mysqli("localhost", "root", "", "jobhive");
if ($sql->connect_error) {
    die("Connection failed: " . $sql->connect_error);
}

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

$stmt = $sql->query("CREATE TABLE IF NOT EXISTS job (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    company_name VARCHAR(50) NOT NULL,
    location VARCHAR(50) NOT NULL,
    salary DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
if ($stmt === TRUE) {
    echo "Table job created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS application (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id INT(6) UNSIGNED NOT NULL,
    jobseeker_id INT(6) UNSIGNED NOT NULL,
    status ENUM('applied', 'interviewed', 'hired', 'rejected') DEFAULT 'applied',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES job(id)
)");
if ($stmt === TRUE) {
    echo "Table application created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS resume (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jobseeker_id INT(6) UNSIGNED NOT NULL,
    resume_file VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
if ($stmt === TRUE) {
    echo "Table resume created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS employer_profile (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employer_id INT(6) UNSIGNED NOT NULL,
    company_description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
if ($stmt === TRUE) {
    echo "Table employer_profile created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS jobseeker_profile (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jobseeker_id INT(6) UNSIGNED NOT NULL,
    profile_description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
if ($stmt === TRUE) {
    echo "Table jobseeker_profile created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS jobseeker_resume (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jobseeker_id INT(6) UNSIGNED NOT NULL,
    resume_file VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
if ($stmt === TRUE) {
    echo "Table jobseeker_resume created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS jobseeker_application (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jobseeker_id INT(6) UNSIGNED NOT NULL,
    job_id INT(6) UNSIGNED NOT NULL,
    status ENUM('applied', 'interviewed', 'hired', 'rejected') DEFAULT 'applied',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
if ($stmt === TRUE) {
    echo "Table jobseeker_application created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS employer_application (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employer_id INT(6) UNSIGNED NOT NULL,
    job_id INT(6) UNSIGNED NOT NULL,
    status ENUM('applied', 'interviewed', 'hired', 'rejected') DEFAULT 'applied',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
if ($stmt === TRUE) {
    echo "Table employer_application created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS jobseekerfeedback (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jobseeker_id INT(6) UNSIGNED NOT NULL,
    feedback TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
if ($stmt === TRUE) {
    echo "Table jobseekerfeedback created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS employerfeedback (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employer_id INT(6) UNSIGNED NOT NULL,
    feedback TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
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