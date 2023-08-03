<?php

require_once('../../config/connection.php');

$search_query = isset($_GET['search_query']) ? mysqli_real_escape_string($connection, $_GET['search_query']) : '';

$query = "SELECT a.*, b.*, c.name AS 'product_name', d.name AS 'user_name', d.phone_number AS 'user_phoneNo', d.email AS 'user_email', d.address AS 'user_address', d.city AS 'user_city', d.state AS 'user_state', d.zip_code AS 'user_postcode'
          FROM orders a
          INNER JOIN order_items b ON a.id = b.order_id
          INNER JOIN products c ON b.product_id = c.id
          INNER JOIN users d ON a.user_id = d.id";

// Add search condition if a search query is provided
if (!empty($search_query)) {
  $query .= " WHERE
              a.id LIKE '%$search_query%' OR
              d.name LIKE '%$search_query%' OR
              d.phone_number LIKE '%$search_query%' OR
              d.email LIKE '%$search_query%' OR
              d.address LIKE '%$search_query%' OR
              d.city LIKE '%$search_query%' OR
              d.state LIKE '%$search_query%' OR
              d.zip_code LIKE '%$search_query%' OR
              c.name LIKE '%$search_query%' OR
              a.order_date LIKE '%$search_query%' OR
              b.quantity LIKE '%$search_query%' OR
              a.total_amount LIKE '%$search_query%'";
}

$result = mysqli_query($connection, $query);

if (!$result) {
  echo "Error: " . mysqli_error($connection);
  exit();
}

// Handle the reset action
if (isset($_GET['reset']) && $_GET['reset'] === 'true') {
  // Redirect back to the page without the search query
  header("Location: ../../admin/orders/view.php");
  exit();
}

?>
