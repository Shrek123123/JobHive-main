
<style>
    body {
        margin: 0;
        padding: 0;
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f8f9fa;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        width: 100%;
        box-sizing: border-box;
    }
</style>

<div class="header">
    <div style="display: flex; align-items: center;">
        <img src="image/logo.png" alt="JobHive Logo" style="height: 50px; margin-right: 10px;">
    </div>
    <div style="display: flex; gap: 15px;">
        <a href="#" style="text-decoration: none; color: #333;">Việc làm</a>
        <a href="#" style="text-decoration: none; color: #333;">Tạo CV</a>
        <a href="#" style="text-decoration: none; color: #333;">Công cụ</a>
        <a href="#" style="text-decoration: none; color: #333;">Cẩm nang nghề nghiệp</a>
    </div>
<<<<<<< Updated upstream
    <div style="display: flex; gap: 15px;">
        <a href="#" style="text-decoration: none; color: #007bff;">Đăng nhập</a>
        <a href="#" style="text-decoration: none; color: #007bff;">Đăng ký</a>
        <a href="#" style="text-decoration: none; color: #007bff;">Đăng tuyển & tìm hồ sơ</a>
=======
    <div style="display: flex; gap: 15px; margin-left: auto; margin-right: 50px;">
        <?php if (isset($_SESSION['username'])): ?>
            <div class="user-dropdown">
                <div class="user-info">
                    <img src="image/defaultavatar.jpg" alt="User Avatar">
                    <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                </div>
                <div class="dropdown-menu">
                    <a href="jobseekerprofile.php">Profile</a>
                    <a href="jobseekerlogout.php">Logout</a>
                </div>
            </div>


        <?php else: ?>
            <div class="guest-options">
                <a href="jobseekerlogin.php" class="btn-login">Login/Register</a>
                <a href="register.php" class="btn-register">Are you an employer? <br><span>Click here to redirect</span></a>
            </div>
        <?php endif; ?>
>>>>>>> Stashed changes
    </div>
</div>
<h1>Welcome to JobHive</h1>
<p>Your one-stop solution for job searching and recruitment.</p>

<h2>Available Jobs</h2>