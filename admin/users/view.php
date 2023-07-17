<?php 
  require_once '../../config/connection.php';
  session_start();

  if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'] || $_SESSION['role'] !== 'admin') {
    header('Location: ../../login.php');
    exit();
  }

  require('../queries/getUsers.php');
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GracefulGlam | Users</title>

  <?php @include('../../layouts/header.php') ?>
  
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
      <?php @include('../../admin/navbar.php'); ?>
    </div>
  </div>

  <div class="container-fluid">
    <div class="container my-4">
      <div class="row justify-content-center my-4">
        <div class="col-lg-10 col-md-6 col-sm-6">
          <div class="card">
            <div class="card-header fw-bold text-center">Users</div>
            <div class="card-body">
              <!-- Alert Message -->
              <div class="alert-container"></div>

              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead class="border">
                    <tr class="table-light">
                      <th scope="col" class="text-center" width="10%">#</th>
                      <th scope="col" class="text-center">Name</th>
                      <th scope="col" class="text-center" width="20%">Joined Date</th>
                      <th scope="col" class="text-center" width="20%">Action</th>
                    </tr>
                  </thead>
                  <tbody class="border" style="vertical-align: middle;">
                      <?php
                        $index = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                          $id = $row['id'];
                          $name = $row['name'];
                          $joinedDate = $row['created_at'];
                      ?>
                      <tr class="border">
                        <td class="text-center">
                          <?php echo $index; ?>
                        </td>
                        <td class="text-center">
                          <?php echo $name; ?>
                        </td>
                        <td class="text-center">
                          <?php echo date('d-m-Y h:i A', strtotime($joinedDate)); ?> 
                        </td>
                        <td class="text-center">
                          <button type="button" class="btn btn-sm btn-secondary"><a href="../users/show.php?product_id=<?php echo $id; ?>" class="text-decoration-none text-white"></ion-icon>View Details</a></button>
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

    <?php @include('../../layouts/scripts.php') ?>
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