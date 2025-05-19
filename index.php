<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$action = $_GET['action'] ?? 'home';

if (in_array($action, ['search','results','quickSearch','quickResults','advancedSearch'])) {
    include_once __DIR__ . '/app/controllers/JobController.php';
    $controller = new JobController();

    switch ($action) {
        // AdvancedSearch Routes
        case 'advancedSearch':
            $controller->advancedSearch();
            break;
        case 'results':
            $controller->searchResults();
            break;

        // <<< Quick Search routes >>>
        case 'quickSearch':
            $controller->quickSearch();
            break;
        case 'quickResults':
            $controller->quickResults();
            break;
    }

    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once __DIR__ . '/homepage/head.php'; ?>
</head>
<body>
  <?php
    include_once __DIR__ . '/homepage/header.php';
    include_once __DIR__ . '/homepage/body.php';
  ?>
</body>
<footer>
  <?php include_once __DIR__ . '/homepage/footer.php'; ?>
</footer>
</html>
