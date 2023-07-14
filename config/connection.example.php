<?php

$host="localhost";
$db="graceful_glam";
$user=""; //eg: root
$password=""; //eg: password

$connection = mysqli_connect($host, $user, $password, $db);

// check if the connection was successful
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>