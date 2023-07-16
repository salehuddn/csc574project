<?php

require_once('../../config/connection.php');

//select all products & join table product_images, categories, subcategories. only limit display 1 image
$query = "SELECT a.*, 
            (SELECT image_path FROM product_images WHERE product_id = a.id LIMIT 1) AS image_path,
            c.name AS 'category_name', 
            d.name AS 'subcategory_name'
          FROM products a
          INNER JOIN categories c ON a.category_id = c.id
          INNER JOIN subcategories d ON a.subcategory_id = d.id";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $index = 1;
} else {
  echo "Error";
}