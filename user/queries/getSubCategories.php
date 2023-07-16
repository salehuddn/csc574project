<?php

require_once('../../config/connection.php');

$query = "SELECT * FROM subcategories";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $subcategories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
  echo "Error";
}