<?php
require_once('../../config/connection.php');
session_start();

if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'] || $_SESSION['role'] !== 'admin') {
  header('Location: ../../login.php');
  exit();
}

if (isset($_SESSION['successMsg'])) {
  $successMsg = $_SESSION['successMsg'];
  unset($_SESSION['successMsg']);
}
if (isset($_SESSION['errorMsg'])) {
  $errorMsg = $_SESSION['errorMsg'];
  unset($_SESSION['errorMsg']);
}

require('../queries/getProductById.php');
require('../queries/updateProductById.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GracefulGlam | Edit Product</title>

  <?php @include('../../layouts/header.php') ?>
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
      <?php @include('../../admin/navbar.php'); ?>
    </div>
  </div>

  <div class="container-fluid">
    <div class="container my-4">
      <div class="row justify-content-center my-4">
          <div class="col-lg-8 col-md-12 col-sm-12">
            <div class="card">
              <div class="card-header fw-bold text-center">Edit Product</div>
              <div class="card-body">
                <!-- Back Button -->
                <div class="d-flex justify-content-start">
                  <a href="../products/view.php" class="mb-3 text-dark text-decoration-none"><ion-icon name="arrow-back-outline"></ion-icon></a>
                </div>

                <!-- Alert Message -->
                <?php if (isset($errorMsg)) : ?>
                    <div class="alert alert-danger"><?php echo $errorMsg; ?></div>
                <?php endif; ?>

                <?php if (isset($successMsg)) : ?>
                    <div class="alert alert-success"><?php echo $successMsg; ?></div>
                <?php endif; ?>

                <form method="post" id="product-form" enctype="multipart/form-data">
                    <input type="hidden" name="productId" value="<?php echo $id; ?>">
                    <div class="mb-3">
                        <label for="productName" class="form-label required-field">Product Name: </label>
                        <input type="text" class="form-control" id="productName" name="productName" value="<?php echo $name; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="productDesc" class="form-label required-field">Description: </label>
                        <textarea class="form-control" name="productDesc" id="productDesc" rows="3" required><?php echo $description; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="productPrice" class="form-label required-field">Price (RM): </label>
                        <input type="number" class="form-control" id="productPrice" name="productPrice" min="1.00" value="<?php echo $price; ?>" required>
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
                                        $selected = ($categoryId == $productCategory) ? 'selected' : '';
                                        echo '<option value="' . $categoryId . '" ' . $selected . '>' . $categoryName . '</option>';
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
                                        $selected = ($subcategoryId == $productSubCategory) ? 'selected' : '';
                                        echo '<option value="' . $subcategoryId . '" ' . $selected . '>' . $subcategoryName . '</option>';
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
                            <input type="number" class="form-control" id="productStock" name="productStock" min="1" value="<?php echo $stock; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="productStock" class="form-label">Sold: </label>
                            <input type="number" class="form-control" id="productStock" name="productStock" min="0" value="<?php echo $sold; ?>" disabled>
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="productImage" class="form-label required-field">Images: </label>
                        <input class="form-control" type="file" id="formFile" name="productImage[]" multiple>
                    </div>

                    <?php if (isset($getImagesResult) && mysqli_num_rows($getImagesResult) > 0) : ?>
                      <div class="mb-3">
                        <label class="form-label">Current Images:</label>
                        <div class="row">
                          <?php while ($image = mysqli_fetch_assoc($getImagesResult)) : ?>
                            <div class="col-md-4 mb-3">
                              <img src="<?php echo $image['image_path']; ?>" alt="Product Image" class="img-thumbnail">
                              <button type="button" class="btn btn-sm btn-danger mt-2 delete-image" data-image-id="<?php echo $image['id']; ?>">Delete</button>
                            </div>
                          <?php endwhile; ?>
                        </div>
                      </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success px-4" name="submit">Save</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
      </div>
    </div>

    <?php @include('../../layouts/scripts.php') ?>
    <script>
    setActiveNavItem();

    $(document).on('click', '.delete-image', function() {
      if (confirm("Are you sure you want to delete this image?")) {
        var imageId = $(this).data('image-id');
        deleteImage(imageId);
      }
    });

    function deleteImage(imageId) {
      $.ajax({
        url: '../queries/destroyProductImage.php',
        method: 'POST',
        data: { imageId: imageId },
        success: function(response) {
          window.location.reload();
        }
      });
    }
    </script>
</body>

</html>