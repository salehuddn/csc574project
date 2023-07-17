<?php 
  require_once '../../config/connection.php';
  session_start();

  $pageTitle = 'Products';

  if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'] || $_SESSION['role'] !== 'user') {
    header('Location: ../../login.php');
    exit();
  }

  require_once '../../user/queries/getProductById.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GracefulGlam | <?= $pageTitle ?> </title>

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
          <div class="card border-0">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <img src="../../admin/<?=$product['image_path']?>" class="img-fluid" alt="<?=$name?>">
                </div>
                <div class="col-md-6">

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
    <!-- Footer -->
    <?php @include('../../layouts/footer.php') ?>
    <!-- Scripts -->
    <?php @include('../../layouts/scripts.php') ?>
</body>

</html>