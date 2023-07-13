<?php

require_once('../config/connection.php');

$query = "SELECT * FROM subcategories";
$result = mysqli_query($connection, $query);
