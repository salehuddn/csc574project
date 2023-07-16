<?php
require_once('../../config/connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
  $productId = $_POST['product_id'];

  //delete product images from product_images table
  $deleteImagesQuery = "DELETE FROM product_images WHERE product_id = $productId";
  $deleteImagesResult = mysqli_query($connection, $deleteImagesQuery);

  //delete product from products table
  $deleteProductQuery = "DELETE FROM products WHERE id = $productId";
  $deleteProductResult = mysqli_query($connection, $deleteProductQuery);

  if ($deleteProductResult && $deleteImagesResult) {
    //success message
    $successMsg = "Product deleted successfully.";
    $_SESSION['successMsg'] = $successMsg;

    $response = array(
      'success' => true,
      'message' => $successMsg
    );

  } else {
    //error message
    $errorMsg = "Error deleting product.";
    $_SESSION['errorMsg'] = $errorMsg;

    $response = array(
      'success' => false,
      'message' => $errorMsg
    );
  }
  echo json_encode($response);
}
?>