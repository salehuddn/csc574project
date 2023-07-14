<?php 
  require_once '../config/connection.php';
  session_start();

  if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'] || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
  }

  require('../queries/getOrders.php');
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GracefulGlam | Orders</title>

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
            <div class="card-header fw-bold text-center">Orders</div>
            <div class="card-body">
              <!-- Alert Message -->
              <div class="alert-container"></div>

              <!-- Search Bar -->
              <div class="d-flex justify-content-end mb-3">
                <form class="d-flex" action="#" method="GET">
                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-outline-success" type="submit"><ion-icon name="search-outline"></ion-icon></button>
                </form>
              </div>
              // boleh je nak gabungkan data dalam satu column.
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead class="border">
                    <tr class="table-light">
                      <th scope="col" class="text-center" width="10%">Order ID</th>
                      <th scope="col" class="text-center">Customer</th>
                      <th scope="col" class="text-center" width="20%">Address</th>
                      <th scope="col" class="text-center">Product Name</th>
                      <th scope="col" class="text-center">Quantity</th>
                      <th scope="col" class="text-center">Amount</th>
                      <th scope="col" class="text-center" width="10%">Order Date</th>
                    </tr>
                  </thead>
                  <tbody class="border" style="vertical-align: middle;">
                      <?php
                        $index = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                          // print_r($row);
                          $id = $row['id'];
                          $userName = $row['user_name'];
                          $userPhoneNo = $row['user_phoneNo'];
                          $userEmail = $row['user_email'];
                          $userAddress = $row['user_address'];
                          $userCity = $row['user_city'];
                          $userState = $row['user_state'];
                          $userPostcode = $row['user_postcode'];
                          $productName = $row['product_name'];
                          $orderDate = $row['order_date'];
                          $quantity = $row['quantity'];
                          $amount = $row['total_amount'];
                      ?>
                      <tr class="border">
                        <td class="text-center">
                          <?php echo $id; ?>
                        </td>
                        <td class="text-start">
                          <?php 
                            echo $userName . ' <br>'; 
                            echo $userPhoneNo . ' <br>';
                            echo $userEmail . '';
                          ?>
                        </td>
                        <td class="text-start">
                          <?php 
                            echo $userAddress . ', <br>';
                            echo $userCity . ', ';
                            echo $userPostcode . ' ';
                            echo $userState;
                          ?>
                        </td>
                        <td class="text-center">
                          <?php echo $productName; ?> 
                        </td>
                        <td class="text-center">
                          <?php echo $quantity; ?>
                        </td>
                        <td class="text-center">
                          RM <?php echo $amount; ?>
                        </td>
                        <td class="text-center">
                          <?php echo date('d-m-Y', strtotime($orderDate)); ?> 
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