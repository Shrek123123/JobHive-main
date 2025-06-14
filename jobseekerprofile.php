<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your profile - JobHive</title>
</head>

<body>

    <?php
    session_start();
    if (!isset($_SESSION['username'])) {
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
        header("Location: $redirect");
        exit();
    }

    // Kiểm tra quyền truy cập jobseekerprofile.php?id=...
    if (isset($_GET['id'])) {
        $profileId = intval($_GET['id']);
        if (!isset($_SESSION['jobseeker_id']) || $_SESSION['jobseeker_id'] != $profileId) {
            // Không cho phép truy cập nếu id không khớp
            header("Location: index.php");
            exit();
        }
    } else {
        // Nếu không có id trên URL, chuyển hướng về trang chính
        header("Location: index.php");
        exit();
    }
    include 'jobseekerprofile/header.php';
    include 'jobseekerprofile/body.php';
    ?>

    <footer>
        <?php
        include 'jobseekerprofile/footer.php';
        ?>
    </footer>
</body>

</html>