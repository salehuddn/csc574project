<?php

require_once('../config/connection.php');

//select all products & join table product_images, categories, subcategories
$query = "SELECT a.*, b.image_path, b.is_primary, c.name AS 'category_name', d.name AS 'subcategory_name'
          FROM products a
          LEFT JOIN product_images b ON a.id = b.product_id
          INNER JOIN categories c ON a.category_id = c.id
          INNER JOIN subcategories d ON a.subcategory_id = d.id";
$result = mysqli_query($connection, $query);

// if (!$result) {
//   die('Query failed: ' . mysqli_error($connection));
// } else {
//   echo 'Query executed successfully.';
// }