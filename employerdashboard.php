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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>JobHive - Post Jobs & Find Candidates</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
  <style>
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
    }

   
  </style>
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