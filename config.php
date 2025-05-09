<?php
$sql = new mysqli("localhost", "root", "", "JobHive");
if ($sql->connect_error) {
    die("Connection failed: " . $sql->connect_error);
}

