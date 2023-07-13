<?php

require_once('../config/connection.php');

$query = "SELECT * FROM users";
$result = mysqli_query($connection, $query);