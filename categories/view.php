<?php 
  require_once '../config/connection.php';
  session_start();

  if (isset($_SESSION['successMsg'])) {
    $successMsg = $_SESSION['successMsg'];
    $type = $_SESSION['type'];

    unset($_SESSION['successMsg']);
    unset($_SESSION['type']);
  }
  if (isset($_SESSION['errorMsg'])) {
    $errorMsg = $_SESSION['errorMsg'];
    $type = $_SESSION['type'];

    unset($_SESSION['errorMsg']);
    unset($_SESSION['type']);
  }
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GracefulGlam | Categories</title>

  <?php @include('../layouts/header.php') ?>
  
  <style>
    .bg-male {
      background-color: #274c77 !important;
    }

    .bg-female {
      background-color: #da627d !important;
    }

    .bg-unisex {
      background-color: #a98467 !important;
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
        <!-- Categories -->
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="card">
            <div class="card-header fw-bold text-center">Categories</div>
            <div class="card-body">
              <!-- Alert Message -->
              <?php if (isset($successMsg) && $type === 'category') : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?php echo $successMsg; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>
              <?php if (isset($errorMsg) && $type === 'category') : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?php echo $errorMsg; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>
              <div class="category-alert-container"></div>

              <!-- Add Product Button -->
              <div class="d-flex justify-content-end mb-3">
                <a href="../categories/create.php?category=true" class="btn btn-primary btn-sm">Add Category</a>
              </div>

              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead class="border">
                    <tr class="table-light">
                    <th scope="col" class="text-center fw-bold" width=10%>#</th>
                      <th scope="col" class="text-center">Name</th>
                      <th scope="col" class="text-center" width=20%>Action</th>
                    </tr>
                  </thead>
                  <tbody class="border">
                      <?php
                        require('../queries/getCategories.php');

                        $index = 1;
                        if ($result && mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $name = $row['name'];
                      ?>
                      <tr class="border">
                        <td class="text-center"><?php echo $index; ?></td>
                        <td class="text-center">
                          <?php 
                            if ($name == 'Men') {
                              echo '<span class="badge bg-male">' .$name ?? ''. '</span>';
                            } else if ($name == 'Women') {
                              echo '<span class="badge bg-female">' .$name ?? ''. '</span>';
                            } else if ($name == 'Unisex') {
                              echo '<span class="badge bg-unisex">' .$name ?? ''. '</span>';
                            } else {
                              echo $name ?? '';
                            }
                          ?> 
                        </td>
                        <td class="text-center">
                          <a href="../categories/edit.php?category=true&category_id=<?php echo $id; ?>" class="text-dark"><ion-icon name="create-outline"></ion-icon></a>
                          <a class="text-dark delete-category" data-category-id="<?php echo $id; ?>" style="cursor: pointer;"><ion-icon name="trash-outline"></ion-icon></a>
                        </td>
                      </tr>
                      <?php
                            $index++;
                          }
                        } else {
                          echo 'No data found';
                        }
                      ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Subcategory -->
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="card">
            <div class="card-header fw-bold text-center">Subcategories</div>
            <div class="card-body">
              <!-- Alert Message -->
              <?php if (isset($successMsg) && $type === 'subcategory') : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?php echo $successMsg; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>
              <?php if (isset($errorMsg) && $type === 'subcategory') : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?php echo $errorMsg; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>
              <div class="subcategory-alert-container"></div>

              <!-- Add Product Button -->
              <div class="d-flex justify-content-end mb-3">
                <a href="../categories/create.php?subcategory=true" class="btn btn-primary btn-sm">Add Subcategory</a>
              </div>

              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead class="border">
                    <tr class="table-light">
                      <th scope="col" class="text-center fw-bold" width=10%>#</th>
                      <th scope="col" class="text-center">Name</th>
                      <th scope="col" class="text-center" width=20%>Action</th>
                    </tr>
                  </thead>
                  <tbody class="border">
                      <?php
                        require('../queries/getSubCategories.php');

                        $index = 1;
                        if ($result && mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $name = $row['name'];
                      ?>
                      <tr class="border">
                        <td class="text-center"><?php echo $index; ?></td>
                        <td class="text-center"><?php echo $name ?? ''; ?></td>
                        <td class="text-center">
                          <a href="../categories/edit.php?subcategory=true&category_id=<?php echo $id; ?>" class="text-dark"><ion-icon name="create-outline"></ion-icon></a>
                          <a class="text-dark delete-subcategory" data-subcategory-id="<?php echo $id; ?>" style="cursor: pointer;"><ion-icon name="trash-outline"></ion-icon></a>
                        </td>
                      </tr>
                      <?php
                            $index++;
                          }
                        } else {
                          echo 'No data found';
                        }
                      ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php @include('../layouts/scripts.php') ?>
    <script>
      $(document).on('click', '.delete-category', function() {
        if (confirm("Are you sure you want to delete this category?")) {
          var categoryId = $(this).data('category-id');
          deleteCategory(categoryId);
        }
      });

      function deleteCategory(categoryId) {
        $.ajax({
          url: '../queries/destroyCategory.php',
          method: 'POST',
          data: { category_id: categoryId },
          success: function(response) {
            var data = JSON.parse(response);

            if (data.success) {
              // Success message
              showAlert('success', data.message);
            } else {
              // Error message
              showAlert('error', data.message);
            }

            if (data.success) {
              setTimeout(function() {
                window.location.href = '../categories/view.php';
              }, 2000);
            }
          }
        });
      }

      $(document).on('click', '.delete-subcategory', function() {
        if (confirm("Are you sure you want to delete this subcategory?")) {
          var subcategoryId = $(this).data('subcategory-id');
          deleteSubcategory(subcategoryId);
        }
      });

      function deleteSubcategory(subcategoryId) {
        $.ajax({
          url: '../queries/destroyCategory.php',
          method: 'POST',
          data: { subcategory_id: subcategoryId },
          success: function(response) {
            var data = JSON.parse(response);

            if (data.success) {
              // Success message
              showAlert('success', data.message);
            } else {
              // Error message
              showAlert('error', data.message);
            }

            if (data.success) {
              setTimeout(function() {
                window.location.href = '../categories/view.php';
              }, 2000);
            }
          }
        });
      }

      function showAlert(type, message) {
        var alertClass = (type === 'success') ? 'alert-success' : 'alert-danger';

        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
          message +
          '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
          '</div>';

        $('.alert-container').html(alertHtml);
      }

    </script>
</body>

</html>