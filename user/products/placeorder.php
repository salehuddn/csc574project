<?php 
  require_once '../../config/connection.php';
  session_start();

  $pageTitle = 'Products';

  if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'] || $_SESSION['role'] !== 'user') {
    header('Location: ../../login.php');
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GracefulGlam | <?= $pageTitle ?> </title>

  <?php @include('../../layouts/header.php') ?>
</head>
<style>
  .badge .rounded-pill .bg-danger {
    font-size: .6em !important;
  }
</style>

<body>
  <div class="container-fluid bg-dark">
    <div class="container">
      <?php @include('../../user/navbar.php'); ?>
    </div>
  </div>

  <div class="container-fluid">
    <div class="container my-4 py-4">
      <div class="row justify-content-center my-4 text-center py-4">
          <h1 class="display-6 mb-4">Your Order Has Been Placed</h1>
          <p class="lead">Thank you for ordering with us! We'll contact you by email with your order details.</p>
      </div>
    </div>
  </div>
  
    <!-- Footer -->
    <?php @include('../../layouts/footer.php') ?>
    <!-- Scripts -->
    <?php @include('../../layouts/scripts.php') ?>
</body>

</html>