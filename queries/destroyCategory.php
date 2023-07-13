<?php
  require_once '../config/connection.php';
  session_start();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['category_id'])) {
      $categoryId = $_POST['category_id'];

      $query = "DELETE FROM categories WHERE id = '$categoryId'";
      $result = mysqli_query($connection, $query);

      if ($result) {
        $_SESSION['successMsg'] = "Category deleted successfully.";
        $_SESSION['type'] = 'category';

        header('Location: ../categories/view.php');
      } else {
        $_SESSION['errorMsg'] = "An error occurred while deleting the category.";
        $_SESSION['type'] = 'category';

        header('Location: ../categories/view.php');
      }
    } elseif (isset($_POST['subcategory_id'])) {
      $subcategoryId = $_POST['subcategory_id'];

      $query = "DELETE FROM subcategories WHERE id = '$subcategoryId'";
      $result = mysqli_query($connection, $query);

      if ($result) {
        $_SESSION['successMsg'] = "Subcategory deleted successfully.";
        $_SESSION['type'] = 'subcategory';

        header('Location: ../categories/view.php');
      } else {
        $_SESSION['errorMsg'] = "An error occurred while deleting the subcategory.";
        $_SESSION['type'] = 'subcategory';

        header('Location: ../categories/view.php');
      }
    }
  }
?>
