<?php
require_once('../../config/connection.php');

if (isset($_POST['submit'])) {
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $productDesc = $_POST['productDesc'];
    $productPrice = $_POST['productPrice'];
    $productCategory = $_POST['productCategory'];
    $productSubCategory = $_POST['productSubCategory'];
    $productStock = $_POST['productStock'];

    //update product in the products table
    $updateProductQuery = "UPDATE products SET 
                           name = '$productName', 
                           description = '$productDesc', 
                           price = $productPrice, 
                           category_id = $productCategory, 
                           subcategory_id = $productSubCategory, 
                           stock = $productStock 
                           WHERE id = $productId";
    $updateProductResult = mysqli_query($connection, $updateProductQuery);

    if ($updateProductResult) {
        //check if new images are uploaded
        if (isset($_FILES['productImage'])) {
            $fileCount = count($_FILES['productImage']['name']);
            for ($i = 0; $i < $fileCount; $i++) {
                $fileName = $_FILES['productImage']['name'][$i];
                $fileTmpName = $_FILES['productImage']['tmp_name'][$i];
                $fileError = $_FILES['productImage']['error'][$i];

                if ($fileError === UPLOAD_ERR_OK) {
                    $uploadDirectory = '../products/images/';
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
        $successMsg = "Product updated successfully.";
        $_SESSION['successMsg'] = $successMsg;

        header("Location: ../products/edit?product_id={$productId}");
    } else {
        //error message
        $errorMsg = "Error updating product.";
        $_SESSION['errorMsg'] = $errorMsg;

        header("Location: ../products/edit?product_id={$productId}");
    }
}
