<?php
require_once '../config/connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['category_id'])) {
    $categoryId = $_POST['category_id'];

    $query = "DELETE FROM categories WHERE id = '$categoryId'";
    $result = mysqli_query($connection, $query);

    if ($result) {
      $successMsg = "Category deleted successfully.";
      $_SESSION['successMsg'] = $successMsg;
      $_SESSION['type'] = 'category';

      $response = array(
        'success' => true,
        'message' => $successMsg
      );
    } else {
      $errorMsg = "An error occurred while deleting the category.";
      $_SESSION['errorMsg'] = $errorMsg;
      $_SESSION['type'] = 'category';

      $response = array(
        'success' => false,
        'message' => $errorMsg
      );
    }

    echo json_encode($response);
  } elseif (isset($_POST['subcategory_id'])) {
    $subcategoryId = $_POST['subcategory_id'];

    $query = "DELETE FROM subcategories WHERE id = '$subcategoryId'";
    $result = mysqli_query($connection, $query);

    if ($result) {
      $successMsg = "Subcategory deleted successfully.";
      $_SESSION['successMsg'] = $successMsg;
      $_SESSION['type'] = 'subcategory';

      $response = array(
        'success' => true,
        'message' => $successMsg
      );
    } else {
      $errorMsg = "An error occurred while deleting the subcategory.";
      $_SESSION['errorMsg'] = $errorMsg;
      $_SESSION['type'] = 'subcategory';

      $response = array(
        'success' => false,
        'message' => $errorMsg
      );
    }

    echo json_encode($response);
  }
}
?>
