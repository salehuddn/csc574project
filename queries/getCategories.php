<?php

require_once('../config/connection.php');
session_start();

$query = "SELECT * FROM categories";
$result = mysqli_query($connection, $query);


