<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobseeker Register - JobHive</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
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
            margin-bottom: 0px;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn-register {
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

        .login-link {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
        }

        .login-link a {
            color: #d90000;
            text-decoration: none;
            font-weight: bold;
        }
        select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background: #fff;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left">
            <h2>Welcome to JobHive! (Employer portal)</h2>
            <p>Let's create an account to start your recruitment journey together!</p>
            <form action="employerregister.php" method="post">
                <div class="form-group">
                    <h3>Account information</h3>
                    <label>Username</label><br>
                    <input type="text" placeholder="Username" name="username" required>
                </div>
                <div class="form-group">
                    <label>Email</label><br>
                    <input type="email" placeholder="Email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label><br>
                    <input type="password" placeholder="Password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Re-enter password</label><br>
                    <input type="password" placeholder="Re-enter password here" name="retypepass" required>
                </div>
                <h3>Company information</h3>
                <div class="form-group">
                    <label>Company name</label><br>
                    <input type="text" placeholder="Company name" name="companyname" required>
                </div>
                <div class="form-group">
                    <label>Company address</label><br>
                    <input type="text" placeholder="Company address" name="companyaddress" required>
                </div>
                <div class="form-group">
                    <label>Field of work</label><br>
                    <select name="industry" required>
                        <option value="">Choose an industry</option>
                        <option value="IT">IT & Software</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Finance">Finance</option>
                        <option value="Healthcare">Healthcare</option>
                        <option value="Government & Public Sector">Government & Public Sector</option>
                    </select>
                </div>
                <button class="btn-register">Register</button>
            </form>
            <div style="display: flex; justify-content: center; align-items: center; gap: 30px; margin-top: 30px;">
                <div class="login-link" style="margin: 0;">
                    Already have an account? <a href="employerlogin.php">Login</a>
                </div>
                <div class="login-link" style="margin: 0;">
                    Are you a jobseeker? <a href="index.php">Click here to redirect</a>
                </div>
            </div>
              <small style="text-align: center; margin-top: 20px;">By registering, you agree to the <a href="term.php">Terms of Use</a> of Job Hive</small>
        </div>
        <div class="right">
            <a href="index.php">
                <img src="image/logo.png" alt="JobHive Logo" style="height: 70px; margin-bottom: 20px;">
            </a>
            <h2>Your Job<br>Is our Hive</h2>
            <p>JobHive - The pionnering job portal destination for foreigners in Vietnam</p>
            <div class="support">
                <p>Having trouble registering?</p>
                <p>Call us at: <strong>012 345 6789</strong></p>
                <p>Email us at: <a href="mailto:support@jobhive.com">support@jobhive.com</a></p>
            </div>
        </div>
    </div>
</body>

</html>

<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $retypepass = $_POST['retypepass'];
    $companyname = $_POST['companyname'];
    $companyaddress = $_POST['companyaddress'];
    $industry = $_POST['industry'];

    // Validate input
    if (empty($username) || empty($email) || empty($password) || empty($retypepass) || empty($companyname) || empty($companyaddress) || empty($industry)) {
        echo "<script>
      alert('All fields are required.');
      window.history.back();
      </script>";
        exit;
    }

    if ($password !== $retypepass) {
        echo "<script>
      const passwordField = document.querySelector('input[name=\"password\"]');
      const errorTooltip = document.createElement('div');
      errorTooltip.textContent = 'Passwords do not match';
      errorTooltip.style.position = 'absolute';
      errorTooltip.style.backgroundColor = '#f8d7da';
      errorTooltip.style.color = '#721c24';
      errorTooltip.style.padding = '5px';
      errorTooltip.style.border = '1px solid #f5c6cb';
      errorTooltip.style.borderRadius = '5px';
      errorTooltip.style.marginTop = '5px';
      errorTooltip.style.fontSize = '12px';
      passwordField.parentNode.appendChild(errorTooltip);
      passwordField.focus();

      setTimeout(() => {
        errorTooltip.remove();
      }, 3000);
      </script>";
        exit;
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
      const emailField = document.querySelector('input[name=\"email\"]');
      const errorTooltip = document.createElement('div');
      errorTooltip.textContent = 'Email already exists';
      errorTooltip.style.position = 'absolute';
      errorTooltip.style.backgroundColor = '#f8d7da';
      errorTooltip.style.color = '#721c24';
      errorTooltip.style.padding = '5px';
      errorTooltip.style.border = '1px solid #f5c6cb';
      errorTooltip.style.borderRadius = '5px';
      errorTooltip.style.marginTop = '5px';
      errorTooltip.style.fontSize = '12px';
      emailField.parentNode.appendChild(errorTooltip);
      emailField.focus();

      setTimeout(() => {
        errorTooltip.remove();
      }, 3000);
      </script>";
        exit;
    }

    // Insert new user into the database
    // Insert user first
    $stmt = $conn->prepare("INSERT INTO user (username, user_type, email, password) VALUES (?, 'employer', ?, ?)");
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    $stmt->execute();

    // Lấy id của user vừa tạo
    $user_id = $conn->insert_id;

    // Chỉ insert vào bảng company nếu user_type là 'employer'
    if ($user_id) {
        $stmt_company = $conn->prepare("INSERT INTO company (employer_id, company_name, company_address, industry) VALUES (?, ?, ?, ?)");
        $stmt_company->bind_param("isss", $user_id, $companyname, $companyaddress, $industry);
        $stmt_company->execute();
        $stmt_company->close();
    }
    if ($stmt->affected_rows > 0) {
        $stmt->close();
        echo "<script>
            alert('Registration successful!');
            window.location.href = 'employerlogin.php';
        </script>";
        exit;
    } else {
        $stmt->close();
        echo "<script>
            alert('Error: " . addslashes($stmt->error) . "');
            window.history.back();
        </script>";
        exit;
    }
}
?>