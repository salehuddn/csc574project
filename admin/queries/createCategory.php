<?php

require_once('../../config/connection.php');

if (isset($_GET['category'])) {
  $pageTitle = 'Create Category';
  $label = 'Category';
  $name = 'category';

  if (isset($_POST[$name])) {
    $categoryName = $_POST[$name];

    $query = "INSERT INTO categories (name) VALUES ('$categoryName')";
    $result = mysqli_query($connection, $query);

    if ($result) {
      $successMsg = "Category created successfully.";
      $_SESSION['successMsg'] = $successMsg;
      $_SESSION['type'] = $name;

      header('Location: ../categories/view.php');
    } else {
      $errorMsg = "Failed to create the category.";
      $_SESSION['errorMsg'] = $errorMsg;
      $_SESSION['type'] = $name;

      header('Location: ../../admin/categories/view.php');
    }
  }
} elseif (isset($_GET['subcategory'])) {
  $pageTitle = 'Create Subcategory';
  $label = 'Subcategory';
  $name = 'subcategory';

  if (isset($_POST[$name])) {
    $subcategoryName = $_POST[$name];

    $query = "INSERT INTO subcategories (name) VALUES ('$subcategoryName')";
    $result = mysqli_query($connection, $query);

    if ($result) {
      $successMsg = "Subcategory created successfully.";
      $_SESSION['successMsg'] = $successMsg;
      $_SESSION['type'] = $name;

      header('Location: ../../admin/categories/view.php');
    } else {
      $errorMsg = "Failed to create the subcategory.";
      $_SESSION['errorMsg'] = $errorMsg;
      $_SESSION['type'] = $name;

      header('Location: ../../admin/categories/view.php');
    }
  }
} else {
  header('Location: ../../index.php');
  exit();
}