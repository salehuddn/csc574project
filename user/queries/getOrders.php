<?php

require_once('../../config/connection.php');

$user_id = $_SESSION['userId'];

$query = "SELECT a.*, b.*, c.name AS 'product_name', (SELECT image_path FROM product_images WHERE product_id = c.id LIMIT 1) AS image_path
          FROM orders a
          INNER JOIN order_items b ON a.id = b.order_id
          INNER JOIN products c ON b.product_id = c.id
          INNER JOIN users d ON a.user_id = d.id
          WHERE a.user_id = $user_id";
$result = mysqli_query($connection, $query);

if ($stmt = mysqli_prepare($connection, $query)) {
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
  $totalOrders = mysqli_num_rows($result);
} else {
  echo "Error";
}