<?php
// You can add any PHP code here, like retrieving job listings from a database, etc.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urgent Job Listings</title>
    <style>
        .urgent-jobs-container {
            background: #fff5f5;
            border: 1px solid #f5c6cb;
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .urgent-jobs-wrapper {
    display: grid;
    grid-template-columns: repeat(3, 1fr); 
    gap: 20px;
    margin-top: 30px;
}

.job-box {
    background: #fff;
    border: 1px solid #f5c6cb;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    text-align: left;
}

.job-box h3 {
    color: #e74c3c;
    margin-bottom: 10px;
}

.job-box p {
    margin: 4px 0;
    font-size: 14px;
}


        .job-categories {
    text-align: center;
    margin-top: 20px;
}

.job-categories button {
    background-color: #fff; /* White background for buttons */
    border: 1px solid #e74c3c; /* Red border for buttons */
    color: #e74c3c; /* Red text color */
    padding: 8px 16px;
    margin: 5px;
    border-radius: 20px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s, color 0.3s; /* Smooth hover effect */
}

.job-categories button:hover {
    background-color: #e74c3c; /* Red background on hover */
    color: white; /* White text color on hover */
}
.nav-buttons {
    text-align: center;
    margin-top: 20px;
}

.nav-buttons button {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 18px;
    margin: 0 10px;
    transition: background-color 0.3s;
}

.nav-buttons button:hover {
    background-color: #c0392b;
}

.nav-buttons button:focus {
    outline: none;
}
.featured-companies-container {
    background: #ffffff;
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 20px;
    width: 100%;
    max-width: 1200px;
    margin: 50px auto 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
}

.featured-companies-title {
    color: #e67e22;
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: left;
}

.featured-companies-logos {
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
    gap: 30px;
    padding-bottom: 10px;
}

.featured-company-logo {
    flex: 0 0 auto;
    background-color: #f8f8f8;
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 140px;
    height: 80px;
    box-shadow: 0 1px 5px rgba(0,0,0,0.03);
    transition: transform 0.3s ease;
}

.featured-company-logo:hover {
    transform: translateY(-3px);
}

.featured-company-logo img {
    max-width: 100%;
    max-height: 60px;
    object-fit: contain;
}

    </style>
</head>
<body>
    <div class="urgent-jobs-container">
        <h2 style="color: #e74c3c;">🔥 Việc làm tuyển gấp</h2>

<div class="job-categories">
    <button>Tất cả</button>
    <button>IT & Software</button>
    <button>Marketing</button>
    <button>Finance</button>
    <button>Healthcare</button>
    <button>Government & Public Sector</button>
</div>

<div class="urgent-jobs-wrapper">
    <div class="job-box">
        <h3>Nhân viên IT (CNTT phần cứng)</h3>
        <p><strong>Công Ty Cổ Phần Dịch Vụ Công Nghệ Hacom</strong> - Hà Nội</p>
        <p>Lương: 10 - 15 triệu</p>
        <p>Ngành: IT & Software</p>
        <p>Ngày đăng: 01/05/2025</p>
    </div>

    <div class="job-box">
        <h3>Junior IT Support</h3>
        <p><strong>Công Ty TNHH Leap Solutions Việt Nam</strong> - TP.HCM</p>
        <p>Lương: 8 - 12 triệu</p>
        <p>Ngành: IT & Software</p>
        <p>Ngày đăng: 02/05/2025</p>
    </div>

    <div class="job-box">
        <h3>Content Marketing/Growth</h3>
        <p><strong>tabtab.me</strong> - Hà Nội</p>
        <p>Lương: 12 - 18 triệu</p>
        <p>Ngành: Marketing</p>
        <p>Ngày đăng: 03/05/2025</p>
    </div>

    <div class="job-box">
        <h3>Chuyên viên Tư Vấn Tài Chính</h3>
        <p><strong>Công Ty Tài Chính ACB</strong> - Hà Nội</p>
        <p>Lương: 15 - 20 triệu</p>
        <p>Ngành: Finance</p>
        <p>Ngày đăng: 04/05/2025</p>
    </div>

    <div class="job-box">
        <h3>Y tá tại Bệnh viện ĐK Quốc tế</h3>
        <p><strong>Bệnh viện ĐK Quốc tế Hòa Bình</strong> - TP.HCM</p>
        <p>Lương: 8 - 12 triệu</p>
        <p>Ngành: Healthcare</p>
        <p>Ngày đăng: 05/05/2025</p>
    </div>

    <div class="job-box">
        <h3>Giám Đốc Dự Án Chính Phủ</h3>
        <p><strong>Cơ Quan Chính Phủ Việt Nam</strong> - Hà Nội</p>
        <p>Lương: 20 - 30 triệu</p>
        <p>Ngành: Government & Public Sector</p>
        <p>Ngày đăng: 06/05/2025</p>
    </div>
</div>
<div class="nav-buttons">
    <button>&#8592;</button> 
    <button>&#8594;</button> 
</div>
</div>
    </div>
    <div class="featured-companies-container">
    <div class="featured-companies-title">🌟 Công Ty Nổi Bật</div>
    <div class="featured-companies-logos">
        <div class="featured-company-logo">
            <img src="https://via.placeholder.com/120x60?text=tabtab.me" alt="tabtab.me">
        </div>
        <div class="featured-company-logo">
            <img src="https://via.placeholder.com/120x60?text=DN+Group" alt="DN Group">
        </div>
        <div class="featured-company-logo">
            <img src="https://via.placeholder.com/120x60?text=NhanHoa" alt="Nhân Hòa">
        </div>
        <div class="featured-company-logo">
            <img src="https://via.placeholder.com/120x60?text=EY" alt="EY">
        </div>
        <div class="featured-company-logo">
            <img src="https://via.placeholder.com/120x60?text=KaroFi" alt="KaroFi">
        </div>
    </div>
</div>
</body>
</html>
