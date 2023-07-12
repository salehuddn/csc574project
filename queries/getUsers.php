<?php

require_once('../config/connection.php');
session_start();

$query = "SELECT * FROM users";
$result = mysqli_query($connection, $query);