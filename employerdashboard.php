<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'login.php';
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
    include 'homepage/header.php';
    include 'homepage/body.php';

    ?>
</body>
<footer>
    <?php
    include 'homepage/footer.php';
    ?>
</footer>

</html>