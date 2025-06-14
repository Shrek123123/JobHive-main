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

// Tạo bảng job
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS job (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    posted_by_employer_id INT UNSIGNED NOT NULL,
    company_name VARCHAR(100) NOT NULL,
    company_size VARCHAR(50),
    job_title VARCHAR(100) NOT NULL,
    job_description TEXT NOT NULL,
    job_benefit TEXT,
    job_requirement TEXT,
    job_location VARCHAR(100) NOT NULL,
    no_employee_needed INT UNSIGNED NOT NULL,
    salary VARCHAR(30) NOT NULL,
    post_duration INT UNSIGNED NOT NULL,
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
    fullname VARCHAR(100) NOT NULL,
    phonenumber VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    cv_file VARCHAR(255),
    allow_search BOOLEAN DEFAULT FALSE,
    UNIQUE (job_id, jobseeker_id),
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

$stmt = $sql->query("CREATE TABLE IF NOT EXISTS job_interest_count (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id INT(6) UNSIGNED NOT NULL,
    interest_count INT(6) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES job(id)
)");
if ($stmt === TRUE) {
    echo "Table job_interest_count created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}
// Tạo bảng saved_jobs
$stmt = $sql->query("CREATE TABLE IF NOT EXISTS saved_jobs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    job_id INT UNSIGNED NOT NULL,
    saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (job_id) REFERENCES job(id) ON DELETE CASCADE,
    UNIQUE (user_id, job_id)
)");
if ($stmt === TRUE) {
    echo "Table saved_jobs created successfully <br>";
} else {
    echo "Error creating table: " . $sql->error;
}

$seedUsers = "
INSERT INTO user (username, user_type, email, password) VALUES
  ('employer1', 'employer', 'employer1@example.com', 'pass1'),
  ('employer2', 'employer', 'employer2@example.com', 'pass2'),
  ('employer3', 'employer', 'employer3@example.com', 'pass3'),
  ('employer4', 'employer', 'employer4@example.com', 'pass4'),
  ('employer5', 'employer', 'employer5@example.com', 'pass5')
";
if ($sql->query($seedUsers) !== TRUE) {
    die("Lỗi khi chèn user mẫu: " . $sql->error);
}

$insertJobs = "
INSERT INTO job (
    posted_by_employer_id, company_name, company_size, job_title,
    job_description, job_benefit, job_requirement, job_location,
    no_employee_needed, salary, post_duration, contact_email,
    contact_phone, job_type, job_category, required_certification,
    job_experience, company_logo
) VALUES
    (1, 'ABC Corp',       '100-200', 'Software Engineer',
     'Phát triển và bảo trì ứng dụng web.', 
     'Health insurance, PTO', 'Java, SQL, Git', 'Hanoi',
     3, '1500-2000 USD', 30, 'hr@abccorp.com',
     '0123456789', 'Full-time', 'IT',
     'Bachelor of Computer Science', '2 years', 'logo1.png'),
    
    (1, 'Tech Innovators','50-100',  'DevOps Engineer',
     'Thiết lập CI/CD, giám sát hệ thống.', 
     'Remote, Bonus', 'Docker, Kubernetes', 'Ho Chi Minh City',
     2, '1800-2200 USD', 45, 'careers@techinnovators.com',
     '0987654321', 'Full-time', 'IT',
     'Cert. Docker/Kubernetes', '3 years', 'logo2.png'),
    
    (2, 'Global Ventures','500+',    'Product Manager',
     'Xây dựng roadmap sản phẩm.', 
     'Stock options, Travel allowance', 'PM tools, Agile', 'Da Nang',
     1, '2000-2500 USD', 60, 'pm@globalventures.com',
     '0112233445', 'Full-time', 'Management',
     'MBA or equivalent', '5 years', 'logo3.png'),
    
    (2, 'Design Hub',     '20-50',   'UX/UI Designer',
     'Thiết kế giao diện người dùng.', 
     'Flexible hours', 'Figma, Photoshop', 'Hai Phong',
     1, '1200-1600 USD', 30, 'jobs@designhub.com',
     '0225367890', 'Full-time', 'Design',
     'Portfolio required', '2 years', 'logo4.png'),
    
    (3, 'HealthTech',     '200-300', 'Data Analyst',
     'Phân tích dữ liệu y tế.', 
     'Health insurance', 'SQL, Python', 'Can Tho',
     2, '1700-2000 USD', 40, 'analytics@healthtech.com',
     '0290372819', 'Full-time', 'Analytics',
     'Bachelor in Statistics', '3 years', 'logo5.png'),
    
    (3, 'FinSecure',      '100-150', 'Security Engineer',
     'Đảm bảo an ninh mạng.', 
     'Cert bonus', 'Pen testing, Firewall', 'Nha Trang',
     1, '1900-2300 USD', 30, 'security@finsecure.com',
     '0258374629', 'Full-time', 'Security',
     'CISSP or CEH', '4 years', 'logo6.png'),
    
    (4, 'EduWorld',       '300-400', 'Curriculum Developer',
     'Xây dựng chương trình học.', 
     'Remote, PTO', 'Research, Writing', 'Hue',
     1, '1300-1600 USD', 45, 'hr@eduworld.com',
     '0234738291', 'Part-time', 'Education',
     'Master in Education', '2 years', 'logo7.png'),
    
    (4, 'MarketGurus',    '50-80',   'Marketing Manager',
     'Lên kế hoạch chiến dịch.', 
     'Commission', 'SEO, AdWords', 'Vung Tau',
     2, '1600-2000 USD', 30, 'marketing@marketgurus.com',
     '0283765432', 'Full-time', 'Marketing',
     'Cert. Google Ads', '3 years', 'logo8.png'),
    
    (5, 'EcoSolutions',   '10-20',   'Environmental Consultant',
     'Tư vấn dự án xanh.', 
     'Field trips', 'Env. assessment', 'Buon Ma Thuot',
     1, '1400-1800 USD', 30, 'consult@ecosolutions.com',
     '0262233445', 'Contract', 'Environmental',
     'Bachelor in Env. Science', '2 years', 'logo9.png'),
    
    (5, 'TravelExperts',  '150-200', 'Sales Representative',
     'Bán tour du lịch.', 
     'Travel perks', 'Communication, Sales', 'Pleiku',
     3, '1100-1400 USD', 30, 'sales@travelexperts.com',
     '0273456123', 'Full-time', 'Sales',
     'Experience in sales', '1 year', 'logo10.png'
);
";

if ($sql->query($insertJobs) === TRUE) {
    echo "Đã chèn 10 bản ghi mẫu vào bảng job thành công.<br>";
} else {
    echo "Lỗi khi chèn dữ liệu: " . $sql->error;
}
