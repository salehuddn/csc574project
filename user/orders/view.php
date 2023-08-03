<?php 
  require_once '../../config/connection.php';
  session_start();

  if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'] || $_SESSION['role'] !== 'user') {
    header('Location: ../../login.php');
    exit();
  }

  require('../../user/queries/getOrders.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GracefulGlam | Orders</title>

  <?php @include('../../layouts/header.php') ?>
</head>

<body>
  <div class="container-fluid bg-dark">
    <div class="container">
      <?php @include('../../user/navbar.php'); ?>
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
                <form class="d-flex" action="" method="GET">
                  <input class="form-control me-2" type="search" name="search_query" placeholder="Search" aria-label="Search">
                  <button class="btn btn-outline-success" type="submit"><ion-icon name="search-outline"></ion-icon></button>
                  <?php if (!empty($_GET['search_query'])): ?>
                    <a href="?reset=true" class="btn btn-outline-secondary ms-2">Reset</a>
                  <?php endif; ?>
                </form>
              </div>
              <?php if (!empty($search_query)): ?>
                <p class="text-center mt-3">
                  Search results for: <strong><?= htmlspecialchars($search_query) ?></strong>
                  <?php if (empty($orders)): ?>
                    (No results found)
                  <?php endif; ?>
                </p>
              <?php endif; ?>

              <div class="table-responsive">
                <table class="table table-bordered align-middle">
                  <thead class="border">
                    <tr class="table-light">
                      <th scope="col" class="text-center" width="10%">Order ID</th>
                      <th scope="col" class="text-center">Product Name</th>
                      <th scope="col" class="text-center" width="10%">Quantity</th>
                      <th scope="col" class="text-center" width="10%">Amount</th>
                      <th scope="col" class="text-center" width="15%">Date</th>
                    </tr>
                  </thead>
                  <tbody class="border" style="vertical-align: middle;">
                    <?php foreach ($orders as $order): 
                        // print_r($order);
                      ?>
                      <tr class="border">
                        <td class="text-center">
                          <?php echo $order['id']; ?>
                        </td>
                        <td class="text-start">
                          <div class="d-flex flex-wrap align-items-center">
                            <?php if (!empty($order['image_path'])) : ?>
                              <a href="../../admin<?php echo $order['image_path']; ?>" target="_blank">
                                <img src="../../admin<?php echo $order['image_path']; ?>" class="rounded float-start me-2" alt="image" width="30" height="30">
                              </a>
                            <?php else : ?>
                              <img src="../../images/no-image-2.png" class="rounded float-start me-2" alt="image" width="30" height="30">
                            <?php endif; ?>

                            <a href="../../user/products/show.php?product_id=<?= $order['product_id'] ?>" class="link-dark text-decoration-none">
                              <?php echo $order['product_name'] ?? '' ?>
                            </a>
                          </div>
                        </td>
                        <td class="text-center">
                          <?php echo $order['quantity']; ?>
                        </td>
                        <td class="text-center">
                          RM <?php echo $order['total_amount']; ?>
                        </td>
                        <td class="text-center">
                          <?php echo date('d-m-Y h:i A', strtotime($order['order_date'])); ?> 
                        </td>
                      </tr>
                      <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php @include('../../layouts/scripts.php') ?>
</body>

</html>