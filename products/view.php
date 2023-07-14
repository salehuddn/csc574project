<?php 
  require_once '../config/connection.php';
  session_start();

  if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'] || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
  }
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GracefulGlam | Products</title>

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
        <div class="col-lg-12 col-md-6 col-sm-6">
          <div class="card">
            <div class="card-header fw-bold text-center">Products</div>
            <div class="card-body">
              <!-- Alert Message -->
              <div class="alert-container"></div>

              <!-- Add Product Button -->
              <div class="d-flex justify-content-end mb-3">
                <a href="../products/create.php" class="btn btn-primary">Add Product</a>
              </div>

              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead class="border">
                    <tr class="table-light">
                      <th scope="col" class="text-center fw-bold">#</th>
                      <th scope="col" class="text-center">Name</th>
                      <th scope="col" class="text-center">Category</th>
                      <th scope="col" class="text-center">Price</th>
                      <th scope="col" class="text-center">Stock</th>
                      <th scope="col" class="text-center">Sold</th>
                      <th scope="col" class="text-center" width="10%">Action</th>
                    </tr>
                  </thead>
                  <tbody class="border">
                      <?php
                        require('../queries/getProducts.php');
                        while ($row = mysqli_fetch_assoc($result)) {
                          $id = $row['id'];
                          $name = $row['name'];
                          $category = $row['category_name'];
                          $subcategory = $row['subcategory_name'];
                          $price = $row['price'];
                          $stock = $row['stock'];
                          $sold = $row['sold'];
                          $image = $row['image_path'];
                      ?>
                      <tr class="border">
                        <td class="text-center">
                          <?php echo $index; ?>
                        </td>
                        <td>
                          <div class="d-flex flex-wrap">
                            <?php if (!empty($image)) : ?>
                              <a href="<?php echo $image; ?>" target="_blank">
                                <img src="<?php echo $image; ?>" class="rounded float-start me-2" alt="image" width="25" height="25">
                              </a>
                            <?php else : ?>
                              <img src="../images/no-image-2.png" class="rounded float-start me-2" alt="image" width="25" height="25">
                            <?php endif; ?>

                            <?php echo $name ?? '' ?>
                          </div>
                        </td>
                        <td class="text-center">
                          <?php 
                          if ($category == 'Men') {
                            echo '<span class="badge bg-male">' .$category. '</span>';
                          } else if ($category == 'Women') {
                            echo '<span class="badge bg-female">' .$category. '</span>';
                          } else if ($category == 'Unisex') {
                            echo '<span class="badge bg-unisex">' .$category. '</span>';
                          } else {
                            echo '';
                          }
                          ?> 
                          <?php echo '<span class="badge bg-secondary">' .$subcategory ?? ''. '</span>'; ?>
                        </td>
                        <td class="text-center">RM <?php echo $price ?? '' ?></td>
                        <td class="text-center"><?php echo $stock ?? '' ?></td>
                        <td class="text-center"><?php echo $sold ?? '' ?></td>
                        <td class="text-center">
                          <a href="../products/edit.php?product_id=<?php echo $id; ?>" class="text-dark"><ion-icon name="create-outline"></ion-icon></a>
                          <a class="text-dark delete-product" data-product-id="<?php echo $id; ?>" style="cursor: pointer;"><ion-icon name="trash-outline"></ion-icon></a>
                        </td>
                      </tr>
                        <?php
                            $index++;
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
      $(document).on('click', '.delete-product', function() {
        if (confirm("Are you sure you want to delete this product?")) {
          var productId = $(this).data('product-id');
          deleteProduct(productId);
        }
      });

      function deleteProduct(productId) {
        $.ajax({
          url: '../queries/destroyProduct.php',
          method: 'POST',
          data: { product_id: productId },
          success: function(response) {
            var data = JSON.parse(response);

            if (data.success) {
              //success message
              showAlert('success', data.message);
            } else {
              //error message
              showAlert('error', data.message);
            }

            if (data.success) {
              setTimeout(function() {
                window.location.href = '../products/view.php';
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