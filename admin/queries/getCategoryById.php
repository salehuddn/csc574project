<?php

require_once('../../config/connection.php');

if (isset($_GET['category'])) {
  $pageTitle = 'Create Category';
  $label = 'Category';
  $name = 'category';
  $id = $_GET['category_id'];
  $query = "SELECT * FROM categories WHERE id = $id";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $name = $row['name'];
  } else {
    echo "Error";
  }

} elseif (isset($_GET['subcategory'])) {
  $pageTitle = 'Create Subcategory';
  $label = 'Subcategory';
  $name = 'subcategory';
  $id = $_GET['category_id'];

  $query = "SELECT * FROM subcategories WHERE id = $id";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $name = $row['name'];
  } else {
    echo "Error";
  }

} else {
  header('Location: ../../index.php');
  exit();
}

