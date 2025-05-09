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
    .btn-social {
      display: flex;
      justify-content: space-around;
      margin-top: 20px;
    }
    .btn-social button {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      font-size: 14px;
      cursor: pointer;
      color: white;
    }
    .google { background: #DB4437; }
    .facebook { background: #3B5998; }
    .linkedin { background: #0077B5; }
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
      <form>
        <div class="form-group">
          <label>Fullname</label><br>
          <input type="text" placeholder="Full Name" required>
        </div>
        <div class="form-group">
          <label>Email</label><br>
          <input type="email" placeholder="Email" required>
        </div>
        <div class="form-group">
          <label>Password</label><br>
          <input type="password" placeholder="Password" required>
        </div>
        <div class="form-group">
          <label>Re-enter password</label><br>
          <input type="password" placeholder="Re-enter password here" required>
        </div>
        <button class="btn-register">Register</button>
      </form>
      <div class="btn-social">
        <button class="google">Google</button>
        <button class="facebook">Facebook</button>
        <button class="linkedin">LinkedIn</button>
      </div>
      <div class="login-link">
        Already have an account? <a href="jobseekerlogin.php">Login</a>
      </div>
    </div>
    <div class="right">
      <h1>JobHive</h1>
      <h2>Your Job<br>Is our Hive</h2>
      <p>JobHive - The pionnering job portal destination for foreigners in Vietnam</p>
    </div>
  </div>
</body>
</html>
