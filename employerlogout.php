<?php
session_start();
session_destroy();
header("job_location: employerpage.php");
exit();
