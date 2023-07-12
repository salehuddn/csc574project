<?php

require_once('../config/connection.php');
session_start();

$query = "SELECT a.*, b.*, c.name as 'product_name'
          FROM orders a
          JOIN order_items b ON a.id = b.order_id
          JOIN products c ON b.product_id = c.id";
$result = mysqli_query($connection, $query);