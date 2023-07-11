<?php

$host="localhost";
$db="graceful_glam";
$user="root";
$password="Revense_2401";

$connection = mysqli_connect($host, $user, $password, $db);

// check if the connection was successful
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>