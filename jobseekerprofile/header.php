<?php
// Đảm bảo đã start session trước khi sử dụng $_SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-right: 50px;
    }

    .user-info img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .user-info span {
        font-size: 16px;
        font-weight: bold;
    }

    .user-dropdown {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: white;
        border: 1px solid #ccc;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        flex-direction: column;
        min-width: 120px;
        z-index: 1000;
    }

    .dropdown-menu a {
        display: block;
        padding: 10px;
        text-decoration: none;
        color: #333;
        border-bottom: 1px solid #eee;
    }

    .dropdown-menu a:last-child {
        border-bottom: none;
    }

    .user-dropdown:hover .dropdown-menu {
        display: flex;
    }

    body {
        margin: 0;
        padding: 0;
    }

    .header {
        display: flex;
        align-items: center;
        background-color: white;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        width: 100%;
        box-sizing: border-box;
    }

    .header nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .navbar {
        display: flex;
        align-items: center;
    }

    .guest-options {
        display: flex;
        gap: 15px;
        margin-left: auto;
        margin-right: 50px;
    }

    .btn-login,
    .btn-register {
        text-decoration: none;
    }
</style>

<div class="header">
    <div style="display: flex; align-items: center;">
        <a href="index.php">
            <img src="image/logo.png" alt="JobHive Logo" style="height: 50px; margin-right: 10px;">
        </a>
    </div>
    <div style="display: flex; gap: 15px; margin-left: 50px;">
        <a href="createcv.php" style="text-decoration: none; color: #333;">Tạo CV</a>
        <a href="tools.php" style="text-decoration: none; color: #333;">Công cụ</a>
        <a href="career-guide.php" style="text-decoration: none; color: #333;">Cẩm nang nghề nghiệp</a>
    </div>
    <div style="display: flex; gap: 15px; margin-left: auto;">
        <div class="user-dropdown">
            <div class="user-info">
                <img src="<?php echo isset($_SESSION['avatar']) ? htmlspecialchars($_SESSION['avatar']) : 'image/defaultavatar.jpg'; ?>" alt="User Avatar">
                <span><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guess'; ?></span>
            </div>
            <div class="dropdown-menu">
                <a href="jobseekerlogout.php">Logout</a>
            </div>
        </div>
    </div>
</div>
