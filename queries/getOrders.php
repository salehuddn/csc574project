<?php

require_once('../config/connection.php');

$query = "SELECT a.*, b.*, c.name AS 'product_name', d.name AS 'user_name', d.phone_number AS 'user_phoneNo', d.email AS 'user_email', d.address AS 'user_address', d.city AS    'user_city', d.state AS 'user_state', d.zip_code AS 'user_postcode'
          FROM orders a
          INNER JOIN order_items b ON a.id = b.order_id
          INNER JOIN products c ON b.product_id = c.id
          INNER JOIN users d ON a.user_id = d.id";
$result = mysqli_query($connection, $query);