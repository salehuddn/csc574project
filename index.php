<?php 
  require_once 'config/connection.php';
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

  <?php @include('layouts/header.php') ?>
</head>

<body>
  <div class="container-fluid bg-dark">
    <div class="container">
      <?php 
        @include('layouts/navbar.php');
      ?>
    </div>
  </div>

  <div class="row myb-2" style="background-image: url(images/featured-image.jpg); background-repeat: no-repeat; background-position: center; background-size: cover;">
    <div class="d-flex flex-column justify-content-center align-items-center text-center text-white d-block mx-auto" style="height: 400px;">
        <h2 class="mx-auto">Gadgets</h2>
        <p class="mx-auto">Essential gadgets for everyday use</p>
    </div>
  </div>

  <div class="container-fluid">
    <div class="container my-4">
      <!-- Header -->
      <div class="row my-2">
        <!-- <div class="d-flex justify-content-end mb-3">
          <?php @include('layouts/search.php'); ?>
        </div> -->
        <div class="card border">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-md-6 p-4 px-5">
                <h2>Free delivery with purchase above RM100</h2>
              </div>
              <div class="col-md-6 p-4 text-center">
                <img src="images/kasut2.jpg" alt="#" width="50%">
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Hot Selling Items -->
      <div class="row my-4">
        <h2>Hot Selling</h2>
        <div class="col">
          <div class="card">
            <div class="row align-items-center">
              <img src="images/kasut2.jpg" alt="#" width="60%">
            </div>
            <div class="px-4 py-2 text-center">
              <p class="fw-bold">KASUT NIKE 1</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card">
            <div class="row align-items-center">
              <img src="images/kasut2.jpg" alt="#" width="60%">
            </div>
            <div class="px-4 py-2 text-center">
              <p class="fw-bold">KASUT NIKE 2</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card">
            <div class="row align-items-center">
              <img src="images/kasut2.jpg" alt="#" width="60%">
            </div>
            <div class="px-4 py-2 text-center">
              <p class="fw-bold">KASUT NIKE 3</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <!-- Footer -->
    <?php @include('layouts/footer.php') ?>

    <!-- Scripts -->
    <?php @include('layouts/scripts.php') ?> 
</body>

</html>