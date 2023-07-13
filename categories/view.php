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
                          <div class="d-flex justify-content-center">
                            <a href="../categories/edit.php?category=true&category_id=<?php echo $id; ?>" class="btn btn-sm text-dark"><ion-icon name="create-outline"></ion-icon></a>
                            <form class="delete-category-form" action="../queries/destroyCategory.php" method="POST">
                              <input type="hidden" name="category_id" value="<?php echo $id; ?>">
                              <button type="submit" class="btn" onclick="return confirm('Are you sure you want to delete this category?')">
                                <ion-icon name="trash-outline"></ion-icon>
                              </button>
                            </form>
                          </div>
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
                          <div class="d-flex justify-content-center">
                            <a href="../categories/edit.php?subcategory=true&category_id=<?php echo $id; ?>" class="btn btn-sm text-dark"><ion-icon name="create-outline"></ion-icon></a>
                            <form class="delete-subcategory-form" action="../queries/destroyCategory.php" method="POST">
                              <input type="hidden" name="subcategory_id" value="<?php echo $id; ?>">
                              <button type="submit" class="btn btn-sm" onclick="return confirm('Are you sure you want to delete this subcategory?')">
                                <ion-icon name="trash-outline"></ion-icon>
                              </button>
                            </form>
                          </div>
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

</body>

</html>