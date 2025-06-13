<?php
session_start();
session_destroy();
header("job_location: index.php");
exit();
