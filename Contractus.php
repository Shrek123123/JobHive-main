

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
       body {
    margin: 0;
    padding: 0;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9f9f9;
    color: #333;
}

.contact-container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 30px;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
}

.contact-container h2 {
    font-size: 28px;
    margin-bottom: 25px;
    color: #e74c3c;
    text-align: center;
}

.contact-info {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 30px;
}

.contact-info div {
    flex: 1;
    min-width: 250px;
}

.contact-info h3 {
    font-size: 18px;
    margin-bottom: 10px;
    color: #555;
}

.contact-info p {
    font-size: 16px;
    line-height: 1.6;
}

..map-container {
    width: 100%;
    height: 500px; /* Tăng từ 400px lên 500px hoặc lớn hơn nếu muốn */
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid #ddd;
}

.map-container iframe {
    width: 100%;
    height: 100%;
    border: 0;
}


    </style>
</head>
<body>
<?php include 'homepage\header.php'; ?>

 <div class="contact-container">
    <h2>Liên hệ với chúng tôi</h2>

    <div class="contact-info">
        <div>
            <h3>Địa chỉ văn phòng</h3>
            <p>1234 Đường Công ty, Quận 1, TP. Hồ Chí Minh</p>
        </div>
        <div>
            <h3>Email</h3>
            <p>contact@jobhive.com</p>
        </div>
        <div>
            <h3>Số điện thoại</h3>
            <p>+84 123 456 789</p>
        </div>
    </div>

    <div class="map-container">
        <h3>Find Us on Google Maps</h3>
        
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.230535335151!2d106.69840871485061!3d10.76315796223071!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752c2a7b44b28b%3A0xc0c0c0c0c0c0c0c0!2zU2hvcCBNYXJrZXQgS3V5QW5oYQ!5e0!3m2!1svi!2s!4v1612506615721!5m2!1svi!2s" 
        allowfullscreen="" loading="lazy"></iframe>
    </div>
</div>

<?php include 'homepage\footer.php'; ?>
</body>
</html>
