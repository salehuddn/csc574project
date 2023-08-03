<?php
require_once('../../config/connection.php');

if (isset($_POST['submit'])) {
  $productName = $_POST['productName'];
    $productDesc = $_POST['productDesc'];
    $productPrice = $_POST['productPrice'];
    $productCategory = $_POST['productCategory'];
    $productSubCategory = $_POST['productSubCategory'];
    $productStock = $_POST['productStock'];

    // Prepare the insert statement using placeholders
    $insertProductQuery = "INSERT INTO products (name, description, price, category_id, subcategory_id, stock) 
                           VALUES (?, ?, ?, ?, ?, ?)";

    // Use prepared statement to safely bind the parameters
    $stmt = mysqli_prepare($connection, $insertProductQuery);
    mysqli_stmt_bind_param($stmt, "ssdiis", $productName, $productDesc, $productPrice, $productCategory, $productSubCategory, $productStock);

    // Execute the prepared statement
    $insertProductResult = mysqli_stmt_execute($stmt);

  if ($insertProductResult) {
      $productId = mysqli_insert_id($connection); //get product ID

      //insert product images into product_images table
      if (isset($_FILES['productImage'])) {
        $fileCount = count($_FILES['productImage']['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = $_FILES['productImage']['name'][$i];
            $fileTmpName = $_FILES['productImage']['tmp_name'][$i];
            $fileError = $_FILES['productImage']['error'][$i];
    
            if ($fileError === UPLOAD_ERR_OK) {
                $uploadDirectory = '../../admin/products/images/';
                $targetFilePath = $uploadDirectory . $fileName;
    
                //move uploaded image to the target directory
                move_uploaded_file($fileTmpName, $targetFilePath);
    
                //insert image details into product_images table
                $insertImageQuery = "INSERT INTO product_images (product_id, image_path) 
                                     VALUES ($productId, '$targetFilePath')";
                mysqli_query($connection, $insertImageQuery);
            }
        }
      }

      //success message
      $productSuccess = "Product added successfully.";
  } else {
      //error message
      $productError = "Error adding product.";
  }
}