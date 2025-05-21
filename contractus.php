<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
     
  
    
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #e74c3c;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        h2 {
            color: #e74c3c;
        }

        .contact-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-top: 20px;
        }

        .contact-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .contact-info div {
            flex: 1;
            margin: 10px;
        }

        .contact-info h3 {
            color: #e74c3c;
        }

        .contact-info p {
            font-size: 16px;
        }

        .map-container {
            width: 100%;
            height: 400px;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 20px;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

    </style>
</head>
<body>
<?php
    include 'homepage/header.php';
    
    ?>
<header>
    <h1>Contact Us</h1>
</header>

<div class="contact-container">
    <h2>Get in Touch</h2>
    
    <div class="contact-info">
        <div>
            <h3>Our Office</h3>
            <p>Chi nhánh TP.Hồ Chí Minh: Phòng 102, Tòa nhà 20–208 Trần Cao Vân, Phường Đa Kao, Quận 1, Thành phố Hồ Chí Minh</p>
            <p>Chi nhánh Hà Nội: Tầng 4, tòa nhà Times Tower, 35 Lê Văn Lương, Thanh Xuân, Hà Nội.</p>
        </div>
        <div>
            <h3>Email Us</h3>
            <p>Email hỗ trợ người tìm việc: ntv@jobhive.vn</p>
            <p>Email hỗ trợ nhà tuyển dụng: ntd@jobhive.vn</p>
        </div>
        <div>
            <h3>Phone</h3>
            <p>(028) 7109 424</p>
            <p>(024) 7109 440</p>
        </div>
    </div>
    
    <div class="map-container">
        <h3>Find Us on Google Maps</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.230535335151!2d106.69840871485061!3d10.76315796223071!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752c2a7b44b28b%3A0xc0c0c0c0c0c0c0c0!2zU2hvcCBNYXJrZXQgS3V5QW5oYQ!5e0!3m2!1svi!2s!4v1612506615721!5m2!1svi!2s" 
        allowfullscreen="" loading="lazy"></iframe>
    </div>
</div>
<?php
    include 'homepage/footer.php';
    
    ?>
</body>
</html>
<!--  -->