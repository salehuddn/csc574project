<?php
require_once('../config/connection.php');

if (isset($_POST['submit'])) {
  $productName = $_POST['productName'];
  $productDesc = $_POST['productDesc'];
  $productPrice = $_POST['productPrice'];
  $productCategory = $_POST['productCategory'];
  $productSubCategory = $_POST['productSubCategory'];
  $productStock = $_POST['productStock'];

  // Insert product into the products table
  $insertProductQuery = "INSERT INTO products (name, description, price, category_id, subcategory_id, stock) 
                         VALUES ('$productName', '$productDesc', $productPrice, $productCategory, $productSubCategory, $productStock)";
  $insertProductResult = mysqli_query($connection, $insertProductQuery);

  if ($insertProductResult) {
      $productId = mysqli_insert_id($connection); // Get the auto-generated product ID

      // Insert product images into the product_images table
      if (isset($_FILES['productImage'])) {
        $fileCount = count($_FILES['productImage']['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = $_FILES['productImage']['name'][$i];
            $fileTmpName = $_FILES['productImage']['tmp_name'][$i];
            $fileError = $_FILES['productImage']['error'][$i];
    
            if ($fileError === UPLOAD_ERR_OK) {
                $uploadDirectory = '../products/images/';
                $targetFilePath = $uploadDirectory . $fileName;
    
                // Move uploaded image to the target directory
                move_uploaded_file($fileTmpName, $targetFilePath);
    
                // Insert image details into product_images table
                $insertImageQuery = "INSERT INTO product_images (product_id, image_path) 
                                     VALUES ($productId, '$targetFilePath')";
                mysqli_query($connection, $insertImageQuery);
            }
        }
      }

      // Success message
      $productSuccess = "Product added successfully.";
  } else {
      // Error message
      $productError = "Error adding product.";
  }
}