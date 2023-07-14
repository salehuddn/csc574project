<?php
require_once('../config/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['imageId'])) {
  $imageId = $_POST['imageId'];

  //retrieve image path
  $getImageQuery = "SELECT image_path FROM product_images WHERE id = $imageId";
  $getImageResult = mysqli_query($connection, $getImageQuery);

  if ($getImageResult && mysqli_num_rows($getImageResult) == 1) {
    $image = mysqli_fetch_assoc($getImageResult);
    $imagePath = $image['image_path'];

    //delete image from the database
    $deleteImageQuery = "DELETE FROM product_images WHERE id = $imageId";
    $deleteImageResult = mysqli_query($connection, $deleteImageQuery);

    if ($deleteImageResult) {
      //delete image file from the server
      if (file_exists($imagePath)) {
        unlink($imagePath);
      }

      echo "Image deleted successfully";
    } else {
      echo "Error deleting image";
    }
  } else {
    echo "Image not found";
  }
} else {
  echo "Invalid request";
}
?>
