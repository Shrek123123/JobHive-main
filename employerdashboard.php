<?php
session_start();
if (!isset($_SESSION['usernameemployer'])) {
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'employerpage.php';
    header("Location: $redirect");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobHive</title>
</head>

<body>
    <?php
    include 'employerpage/header.php';
    include 'employerpage/body.php';

    ?>
</body>
<footer>
    <?php
    include 'employerpage/footer.php';
    ?>
</footer>

</html>