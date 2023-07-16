<?php 

require_once('../config/connection.php');

if (isset($_GET['category'])) {
  $type = 'category';

  if (isset($_POST['submit'])) {
    $categoryName = $_POST[$name];
    $id = $_POST[$id];

    $query = "UPDATE categories SET name = '$categoryName' WHERE id = $id";
    $result = mysqli_query($connection, $query);

    if ($result) {
      session_start();
      $successMsg = "Category updated successfully.";
      $_SESSION['successMsg'] = $successMsg;
      $_SESSION['type'] = $type;

      header('Location: ../categories/view.php');
    } else {
      $errorMsg = "Failed to update the category.";
      $_SESSION['errorMsg'] = $errorMsg;
      $_SESSION['type'] = $type;

      header('Location: ../categories/view.php');
    }
  }
} elseif (isset($_GET['subcategory'])) {
  $type = 'subcategory';

  if (isset($_POST['submit'])) {
    $subcategoryName = $_POST[$name];
    $id = $_POST[$id];

    $query = "UPDATE subcategories SET name = '$subcategoryName' WHERE id = $id";
    $result = mysqli_query($connection, $query);

    if ($result) {
      session_start();
      $successMsg = "Subcategory updated successfully.";
      $_SESSION['successMsg'] = $successMsg;
      $_SESSION['type'] = $type;

      header('Location: ../categories/view.php');
    } else {
      session_start();
      $errorMsg = "Failed to update the subcategory.";
      $_SESSION['errorMsg'] = $errorMsg;
      $_SESSION['type'] = $type;

      header('Location: ../categories/view.php');
    }
  }
} else {
  header('Location: ../../index.php');
  exit();
}