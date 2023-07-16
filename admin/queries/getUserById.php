<?php

require_once('../../config/connection.php');

$id = $_GET['product_id'];
$query = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) == 1) {
  $row = mysqli_fetch_assoc($result);
  $id = $row['id'];
  $name = $row['name'];
  $email = $row['email'];
  $joinedDate = $row['created_at'];
  $address = $row['address'];
  $city = $row['city'];
  $state = $row['state'];
  $postcode = $row['zip_code'];

} else {
  $msg =  "Error";
}

$orderQuery = "SELECT a.*, b.*, c.name AS `product_name`, c.price AS `product_price`
              FROM orders a
              INNER JOIN order_items b ON a.id = b.order_id
              INNER JOIN products c ON b.product_id = c.id
              WHERE a.user_id = $id";
$orderResult = mysqli_query($connection, $orderQuery);

if ($orderResult && mysqli_num_rows($orderResult) > 0) {
  $index = 1;
} else {
  $orderMsg = "No order found.";
}