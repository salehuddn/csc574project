<?php

require_once('../../config/connection.php');

$category = $_GET['category'];
$subcategory = $_GET['subcategory'];

//get category name
if ($category != 'all') {
  $cquery = "SELECT name FROM categories WHERE id = $category LIMIT 1";
  $cresult = mysqli_query($connection, $cquery);
  if ($cresult && mysqli_num_rows($cresult) > 0) {
    $categoryRow = mysqli_fetch_assoc($cresult);
    $categoryName = $categoryRow['name'];
  }
}

//get subcategory
if (!empty($subcategory)) {
  $scquery = "SELECT name FROM subcategories WHERE id = $subcategory LIMIT 1";
  $scresult = mysqli_query($connection, $scquery);
  if ($scresult && mysqli_num_rows($scresult) > 0) {
    $subcategoryRow = mysqli_fetch_assoc($scresult);
    $subcategoryName = $subcategoryRow['name'];
  }
}

$query = "SELECT a.*, 
        (SELECT image_path FROM product_images WHERE product_id = a.id LIMIT 1) AS image_path,
        c.name AS 'category_name', 
        d.name AS 'subcategory_name'
      FROM products a
      INNER JOIN categories c ON a.category_id = c.id
      INNER JOIN subcategories d ON a.subcategory_id = d.id";

if ($category == 'all') {
  $pageTitle = 'All Products';
} else {
  $query .= " WHERE c.id = $category";
  $pageTitle = $categoryName . ' Products';
} 

if (!empty($subcategory)) {
  $query .= " AND d.id = ?";
  $pageTitle .= ' - ' . $subcategoryName;
}

//use prepared statement to safely bind the subcategory value
if ($stmt = mysqli_prepare($connection, $query)) {
  if (!empty($subcategory)) {
    mysqli_stmt_bind_param($stmt, "s", $subcategory);
  }
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
  $totalProducts = mysqli_num_rows($result);
} else {
  echo "Error";
}