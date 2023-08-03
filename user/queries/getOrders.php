<?php

require_once('../../config/connection.php');

$user_id = $_SESSION['userId'];
$search_query = isset($_GET['search_query']) ? mysqli_real_escape_string($connection, $_GET['search_query']) : '';

$query = "SELECT a.*, b.*, c.name AS 'product_name', (SELECT image_path FROM product_images WHERE product_id = c.id LIMIT 1) AS image_path
          FROM orders a
          INNER JOIN order_items b ON a.id = b.order_id
          INNER JOIN products c ON b.product_id = c.id
          INNER JOIN users d ON a.user_id = d.id
          WHERE a.user_id = $user_id";

// Add search condition if a search query is provided
if (!empty($search_query)) {
  $query .= " AND (c.name LIKE '%$search_query%' OR a.id LIKE '%$search_query%')";
}

$result = mysqli_query($connection, $query);

if ($stmt = mysqli_prepare($connection, $query)) {
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
  $totalOrders = mysqli_num_rows($result);
} else {
  echo "Error";
}

// Handle the reset action
if (isset($_GET['reset']) && $_GET['reset'] === 'true') {
  // Clear the search query
  header("Location: ../../user/orders/view.php");
  exit();
}