<?php
$conn = new mysqli("localhost", "root", "", "JobHive");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
