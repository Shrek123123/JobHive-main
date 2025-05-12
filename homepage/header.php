<style>
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
    .navbar{
        display: flex;
        align-items: center;
    }
    .main-menu {
        display: flex;
        text-decoration: none;
      
    }
    .main-menu li {
        margin-left: 30px;
    }
    .main-menu li a{
        text-decoration: none;
        color: #000;

    }
    .main-menu ul.sub-menu {
        position: absolute;
        background-color: #ddd;
    }
    .btnfunction a{
        text-decoration: none;
        margin-left: 20px;
    }
    .btn-register {
        background-color: #D91616;
        color: white;
        padding: 5px 10px;
        border-radius: 10px;
        box-shadow: #a39d9d 0px 5px 5px;
    }
    .btn-register:hover {
        background-color: #fff;
        color: #D91616;
        font-weight: bold;
    }
    .btn-login {
        background-color: #EFCDCD;
        color: #D91616;
        padding: 5px 10px;
        border-radius: 10px;
        box-shadow: #a39d9d 0px 5px 5px;
    }
    .btn-login:hover {
        background-color: #D91616;
        color: white;
        font-weight: bold;
    }
    .btn-cv {
        background-color: #4B4D4B;
        color: white;
        padding: 5px 10px;
        border-radius: 10px;
        box-shadow: #a39d9d 0px 5px 5px;
    }
    .btn-cv:hover {
        background-color: #fff;
        color: #4B4D4B;
        font-weight: bold;
    }

</style>

<div class="header">
    <nav>
        <div class="navbar">
            <a href="index.php">
                    <img src="image/logo.png" alt="JobHive Logo" style="height: 50px; margin-right: 10px;">
            </a>
            <ul class="main-menu">
                <li><a href="">Việc làm</a></li>
                <li><a href="">Tạo CV</a></li>
                <li><a href="">Công cụ</a></li>
                <li><a href="">Cẩm nang nghề nghiệp</a></li>
            </ul>
        </div>
        <div class="btnfunction">
            <a href="jobseekerlogin.php" class="btn-login">Login</a>
            <a href="jobseekerregister.php" class="btn-register">Register</a>
            <a href="" class="btn-cv">Job Recruitment</a>
        </div>

    
    </nav>
    
</div>