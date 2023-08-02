<?php 
  require_once '../config/connection.php';
  session_start();

  if (isset($_GET['registration']) && $_GET['registration'] === 'success') {
      echo '<div class="alert alert-success">Registration successful! You can now log in.</div>';
  }

  if (isset($_SESSION['logoutMessage'])) {
    $logoutMessage = $_SESSION['logoutMessage'];

    //unset the logout message in the session
    unset($_SESSION['logoutMessage']);

    //display the logout message as alert
    echo '<script>window.alert("' . $logoutMessage . '");</script>';
  }

  if (isset($_SESSION['loginMessage'])) {
    $loginMessage = $_SESSION['loginMessage'];

    //unset the login message in the session
    unset($_SESSION['loginMessage']);

    //display the login message as alert
    echo '<script>window.alert("' . $loginMessage . '");</script>';
  }

  $registeredUsersQuery = "SELECT COUNT(*) as userCount FROM users";
  $registeredUsersResult = mysqli_query($connection, $registeredUsersQuery);
  $registeredUsersData = mysqli_fetch_assoc($registeredUsersResult);
  $registeredUsersCount = $registeredUsersData['userCount'];

  // Fetch today's orders count and total sales
  $today = date('Y-m-d');
  $todayOrdersQuery = "SELECT COUNT(*) as orderCount, SUM(total_amount) as totalSales FROM orders WHERE DATE(order_date) = '$today'";
  $todayOrdersResult = mysqli_query($connection, $todayOrdersQuery);
  $todayOrdersData = mysqli_fetch_assoc($todayOrdersResult);
  $todayOrdersCount = $todayOrdersData['orderCount'];
  $todayTotalSales = $todayOrdersData['totalSales'];

  // Fetch monthly total sales
  $currentMonth = date('m');
  $monthlySalesQuery = "SELECT SUM(total_amount) as totalSales FROM orders WHERE MONTH(order_date) = '$currentMonth'";
  $monthlySalesResult = mysqli_query($connection, $monthlySalesQuery);
  $monthlySalesData = mysqli_fetch_assoc($monthlySalesResult);
  $monthlyTotalSales = $monthlySalesData['totalSales'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GracefulGlam</title>

  <?php @include('../layouts/header.php') ?>
</head>

<body>
  <div class="container-fluid bg-dark">
    <div class="container">
      <?php 
        @include('../admin/navbar.php');
      ?>
    </div>
  </div>

  <div class="container-fluid">
    <div class="container my-4">
      <div class="row my-4">
        <!-- Registered Users Count -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Registered Users</h5>
              <p class="card-text"><?php echo $registeredUsersCount; ?></p>
            </div>
          </div>
        </div>
        <!-- Today's Orders and Sales -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Today's Orders</h5>
              <p class="card-text"><?php echo $todayOrdersCount; ?> orders</p>
              <p class="card-text">Total Sales: RM <?php echo number_format($todayTotalSales, 2); ?></p>
            </div>
          </div>
        </div>
        <!-- Monthly Sales -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Monthly Sales</h5>
              <p class="card-text">Total Sales: RM <?php echo number_format($monthlyTotalSales, 2); ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <!-- Footer -->
    <?php @include('../layouts/footer.php') ?>

    <!-- Scripts -->
    <?php @include('../layouts/scripts.php') ?> 
</body>

</html>