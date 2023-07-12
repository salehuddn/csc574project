<?php 
  require_once('../config/connection.php');
  session_start();
  
  if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'] || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
  }
  
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GracefulGlam | Profile</title>

  <?php @include('../layouts/header.php') ?>
  <style>
    .required-field::after {
      content: " *";
      color: red;
      display: inline;
    }
  </style>
</head>

<body>
  <div class="container-fluid bg-dark">
    <div class="container">
      <?php @include('../layouts/navbar.php'); ?>
    </div>
  </div>

  <div class="container-fluid">
    <div class="container my-4">
      <div class="row justify-content-center my-4">
          <div class="col-lg-8 col-md-12 col-sm-12">
            <div class="card">
              <div class="card-header fw-bold text-center">Create Product</div>
              <div class="card-body">
                <?php if (isset($productSuccess)) : ?>
                    <div class="alert alert-success"><?php echo $productSuccess; ?></div>
                <?php endif; ?>
                <?php if (isset($productError)) : ?>
                    <div class="alert alert-danger"><?php echo $productError; ?></div>
                <?php endif; ?>

                <form method="post" id="product-form" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="productName" class="form-label required-field">Product Name: </label>
                        <input type="text" class="form-control" id="productName" name="productName" required>
                    </div>

                    <div class="mb-3">
                        <label for="productDesc" class="form-label required-field">Description: </label>
                        <textarea class="form-control" name="productDesc" id="productDesc" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="productPrice" class="form-label required-field">Price (RM): </label>
                        <input type="number" class="form-control" id="productPrice" name="productPrice" min="1.00" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="productCategory" class="form-label required-field">Category: </label>
                            <select class="form-select" name="productCategory" required>
                                <option value="" disabled selected>Choose..</option>
                                <?php
                                require('../queries/getCategories.php');

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $categoryId = $row['id'];
                                        $categoryName = $row['name'];
                                        echo '<option value="' . $categoryId . '">' . $categoryName . '</option>';
                                    }
                                } else {
                                    echo 'No categories found';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="productSubCategory" class="form-label required-field">Sub Category: </label>
                            <select class="form-select" name="productSubCategory" required>
                                <option value="" disabled selected>Choose..</option>
                                <?php
                                require('../queries/getSubCategories.php');

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $subcategoryId = $row['id'];
                                        $subcategoryName = $row['name'];
                                        echo '<option value="' . $subcategoryId . '">' . $subcategoryName . '</option>';
                                    }
                                } else {
                                    echo 'No subcategories found';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="productStock" class="form-label required-field">Available Stock: </label>
                            <input type="number" class="form-control" id="productStock" name="productStock" min="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="productStock" class="form-label">Sold: </label>
                            <input type="number" class="form-control" id="productStock" name="productStock" min="0" disabled>
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="productImage" class="form-label required-field">Image: </label>
                        <input class="form-control" type="file" id="formFile" name="productImage[]" multiple required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success px-4" name="submit">Save</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
      </div>
    </div>

    <?php @include('../layouts/scripts.php') ?>
    <script>
    setActiveNavItem();
    </script>
</body>

</html>