<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <job_title>Jobseeker Register - JobHive</job_title>
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

    input[type="checkbox"] {
      width: auto;
      padding: 0;
      border-radius: 0;
      border: none;
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
  </style>
</head>

<body>
  <div class="container">
    <div class="left">
      <h2>Welcome to JobHive! (Job Seeker portal)</h2>
      <p>Let's create an account to start your employment journey together!</p>
      <form action="jobseekerregister.php" method="post">
        <div class="form-group">
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
        <button class="btn-register">Register</button>
      </form>
      <div class="login-link">
        Already have an account? <a href="jobseekerlogin.php">Login</a>
      </div>
      <div style="text-align: center; margin-top: 20px;">
        <p>Are you an employer? <a href="employerpage.php">Click here to redirect</a></p>
      </div>
      <div style="margin-top: 20px; display: flex; flex-direction: column; align-items: center;">
        <div style="display: flex; align-items: center;">
          <input type="checkbox" name="terms" value="accepted" style="margin-right: 5px;" required>
          <small>I have read and agree to the <a href="term.html">Terms of Use</a> of JobHive</small>
        </div>
        <span id="terms-error" style="color: red; font-size: 0.9em; margin-top: 5px; display: none;"></span>
      </div>
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

  // Validate input
  if (empty($username) || empty($email) || empty($password) || empty($retypepass)) {
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
  $stmt = $conn->prepare("INSERT INTO user (username, user_type, email, password) VALUES (?, 'jobseeker', ?, ?)");
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $stmt->bind_param("sss", $username, $email, $hashed_password);

  if ($stmt->execute()) {
    // Sử dụng JavaScript để hiển thị thông báo và chuyển hướng
    echo "<script>
        alert('Registration successful!');
        window.job_location.href = 'jobseekerlogin.php';
    </script>";
    exit;
  } else {
    echo "<script>
        alert('Error: " . $stmt->error . "');
    </script>";
    exit;
  }
}

$conn->close();

?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const termsCheckbox = document.querySelector('input[name="terms"]');
    const termsError = document.getElementById('terms-error');

    form.addEventListener('submit', function(event) {
      if (!termsCheckbox.checked) {
        event.preventDefault(); // Ngăn chặn form submit
        termsError.textContent = 'Please read the terms and check the box';
        termsError.style.display = 'block'; // Hiển thị thông báo lỗi

        // Thiết lập thời gian chờ 3 giây (3000 milliseconds) để ẩn thông báo
        setTimeout(function() {
          termsError.style.display = 'none';
          termsError.textContent = ''; // Xóa nội dung thông báo (tùy chọn)
        }, 3000);
      } else {
        termsError.style.display = 'none'; // Ẩn thông báo lỗi nếu checkbox được chọn
      }
    });
  });
</script>