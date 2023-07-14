<?php

require_once('../config/connection.php');

$query = "SELECT * FROM users WHERE role = 'user'";
$result = mysqli_query($connection, $query);