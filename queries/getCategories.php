<?php

require_once('../config/connection.php');

$query = "SELECT * FROM categories";
$result = mysqli_query($connection, $query);


