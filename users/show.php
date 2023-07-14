<?php 
  require_once('../config/connection.php');
  session_start();
  
  if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('Location: login.php');
    exit();
  }

  require('../queries/getUserById.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GracefulGlam | User Details</title>

  <?php @include('../layouts/header.php') ?>
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
          <!-- Profile -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header fw-bold text-center">Profile</div>
              <div class="card-body">
                <table class="table table-borderless">
                  <thead>
                  <tbody>
                    <tr>
                      <th scope="row">Name:</th>
                      <td><?php echo $name; ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Email: </th>
                      <td><?php echo $email; ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Joined Date: </th>
                      <td><?php echo date('d-m-Y h:i A', strtotime($joinedDate)); ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Billing Address -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header fw-bold text-center">Billing Address</div>
              <div class="card-body">
                  <table class="table table-borderless">
                    <thead>
                    <tbody>
                      <tr>
                        <th scope="row">Address:</th>
                        <td><?php echo $address; ?></td>
                      </tr>
                      <tr>
                        <th scope="row">City: </th>
                        <td><?php echo $city; ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Postcode: </th>
                        <td><?php echo $postcode; ?></td>
                      </tr>
                      <tr>
                        <th scope="row">State: </th>
                        <td><?php echo $state; ?></td>
                      </tr>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
      </div>

      <!-- Purchase History -->
      <div class="row justify-content-center my-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header fw-bold text-center">Purchase History</div>
              <div class="card-body">
                <!-- Search Bar -->
                <div class="d-flex justify-content-end mb-3">
                  <form class="d-flex" action="#" method="GET">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit"><ion-icon name="search-outline"></ion-icon></button>
                  </form>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead class="border">
                      <tr class="text-center fw-bold">
                        <td scope="col">#</td>
                        <td scope="col" width="20%">Date</td>
                        <td scope="col">Product Name</td>
                        <td scope="col" width="15%">Quantity</td>
                        <td scope="col" width="15%">Amount</td>
                      </tr>
                    <tbody class="border">
                      <?php
                        if (isset($orderMsg)) {
                          echo '<tr><td colspan="5" class="text-center">' . $orderMsg . '</td></tr>';
                        } else {
                          while ($row = mysqli_fetch_assoc($orderResult)) {
                            $id = $row['id'];
                            $orderDate = $row['order_date'];
                            $amount = $row['total_amount'];
                            $quantity = $row['quantity'];
                            $productName = $row['product_name'];
                            $productPrice = $row['product_price'];
                      ?>
                          <tr class="border">
                            <td class="text-center">
                              <?php echo $index; ?>
                            </td>
                            <td class="text-center">
                              <?php echo date('d-m-Y h:i A', strtotime($orderDate)); ?>
                            </td>
                            <td class="text-center">
                              <?php echo $productName; ?>
                            </td>
                            <td class="text-center">
                              <?php echo $quantity; ?>
                            </td>
                            <td class="text-center">
                              RM <?php echo $productPrice; ?>
                            </td>
                          </tr>
                      <?php
                            $index++;
                          }
                        }
                      ?>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
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