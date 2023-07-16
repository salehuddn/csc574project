<?php
require_once('../../config/connection.php');

$id = $_GET['product_id'];

$productQuery = "SELECT a.*, b.name AS category_name, c.name AS subcategory_name
                 FROM products a
                 INNER JOIN categories b ON a.category_id = b.id
                 INNER JOIN subcategories c ON a.subcategory_id = c.id
                 WHERE a.id = $id";
$productResult = mysqli_query($connection, $productQuery);

if ($productResult && mysqli_num_rows($productResult) == 1) {
  $productRow = mysqli_fetch_assoc($productResult);
  $id = $productRow['id'];
  $name = $productRow['name'];
  $description = $productRow['description'];
  $price = $productRow['price'];
  $stock = $productRow['stock'];
  $sold = $productRow['sold'];
  $productCategory = $productRow['category_id'];
  $productSubCategory = $productRow['subcategory_id'];

} else {
  echo "Error";
}

$getImagesQuery = "SELECT * FROM product_images WHERE product_id = $id";
$getImagesResult = mysqli_query($connection, $getImagesQuery);
?>
