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
      <?php @include('../user/navbar.php'); ?>
    </div>
  </div>

  <div class="container-fluid">
    <div class="container my-4">
      <!-- User Dashboard -->
      <div class="row">
        <div class="col-md-12">
          <h2>Welcome, <?php echo $_SESSION['userName']; ?>!</h2>
          <p>Here's an overview of your account:</p>
        </div>
      </div>

      <div class="row my-4">
        <!-- Order History -->
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Order History</h5>
              <?php
                $userId = $_SESSION['userId'];
                $orderHistoryQuery = "SELECT * FROM orders WHERE user_id = $userId ORDER BY order_date DESC";
                $orderHistoryResult = mysqli_query($connection, $orderHistoryQuery);

                if (mysqli_num_rows($orderHistoryResult) > 0) {
                  while ($row = mysqli_fetch_assoc($orderHistoryResult)) {
                    echo '<p>Order ID: ' . $row['id'] . ' - Date: ' . $row['order_date'] . ' - Total Amount: RM ' . number_format($row['total_amount'], 2) . '</p>';
                  }
                } else {
                  echo '<p>No orders found.</p>';
                }
              ?>
            </div>
          </div>
        </div>
        <!-- Account Information -->
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Account Information</h5>
              <?php
                $userId = $_SESSION['userId'];
                $accountInfoQuery = "SELECT * FROM users WHERE id = $userId";
                $accountInfoResult = mysqli_query($connection, $accountInfoQuery);

                if (mysqli_num_rows($accountInfoResult) > 0) {
                  $userInfo = mysqli_fetch_assoc($accountInfoResult);
                  echo '<p>Name: ' . $userInfo['name'] . '</p>';
                  echo '<p>Email: ' . $userInfo['email'] . '</p>';
                  echo '<p>Registered at: ' . $userInfo['created_at'] . '</p>';
                } else {
                  echo '<p>Account information not available.</p>';
                }
              ?>
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
    <script>
    setActiveNavItem();
    </script>
</body>

</html>