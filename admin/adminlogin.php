<?php
session_start();
require_once __DIR__ . '/../config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Password_hash
    $result = $conn->query("SELECT id, password FROM user");
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $plainPassword = $row['password'];
    
        // Chỉ hash nếu chưa phải mật khẩu mã hóa (không bắt đầu bằng $2y$)
        if (strpos($plainPassword, '$2y$') !== 0) {
            $hashed = password_hash($plainPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE user SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $hashed, $id);
            $stmt->execute();
        }
    }

    // Check if the email and password are correct
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? AND user_type = 'admin'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    
    
    echo "Đã cập nhật mật khẩu với password_hash().";

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct
            $_SESSION['usernameadmin'] = $row['username'];
            header("Location: admindashboard.php");
            exit();
        } else {
            // Invalid password
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorDiv = document.createElement('div');
                errorDiv.style.color = 'red';
                errorDiv.style.textAlign = 'center';
                errorDiv.style.marginTop = '10px';
                errorDiv.innerText = 'Invalid password. Please try again.';
                document.querySelector('input[name=\"password\"]').parentNode.appendChild(errorDiv);
            });
            </script>";
        }
    } else {
        // Email not found
        echo "<script>alert('Invalid email. Please try again.');</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobSeeker Login - JobHive</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }

        .container {
            display: flex;
            flex: 1;
        }

        .left {
            flex: 1;
            background: #f3f3f3;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right {
            flex: 1;
            background: white;
            color: #8B0000;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        h2 {
            color: #d90000;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #d90000;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .forgot {
            text-align: right;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left">
            <h2>Welcome admin</h2>
            <p>Let's kickstart your profile to new heights with JobHive</p>
            <form accept="adminlogin.php" method="POST">
                <div class="form-group">
                    <label>Email</label><br>
                    <input type="email" placeholder="Email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label><br>
                    <input type="password" placeholder="Password" name="password" required>
                    <div class="forgot"><a href="jobseekerforgetpassword.php">Forget password</a></div>
                </div>
                <button class="btn-login">Login</button>
            </form>
        </div>
        <div class="right">
            <a href="../index.php">
                <img src="../image/logo.png" alt="JobHive Logo" style="height: 70px; margin-bottom: 20px;">
            </a>
            <h2>Your Job<br>Is our Hive</h2>
            <p>JobHive - The pionnering job portal destination for foreigners in Vietnam</p>
            <div class="support">
                <p>Having trouble logging in?</p>
                <p>Call us at: <strong>012 345 6789</strong></p>
                <p>Email us at: <a href="mailto:support@jobhive.com">support@jobhive.com</a></p>
            </div>
        </div>

    </div>
</body>

</html>