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

  <style>
    html,
    body {
      overflow-x: hidden;
    }

    .zoom-container {
      width: 300px; /* Set the container size to your desired image size */
      height: 300px;
      overflow: hidden;
    }

    .zoom-container img {
      transition: transform 0.3s ease;
    }

    .zoom-container:hover img {
      transform: scale(1.1); /* Increase the scale to zoom in (1.1 means 10% zoom) */
    }
  </style>
</head>

<body>
  <div class="container-fluid bg-dark">
    <div class="container">
      <?php 
        @include('layouts/navbar.php');
      ?>
    </div>
  </div>

  <div class="row" style="background-image: url(images/featured-image.jpg); background-repeat: no-repeat; background-position: center; background-size: cover;">
    <div class="d-flex flex-column justify-content-center align-items-center text-center text-white d-block mx-auto" style="height: 300px;">
        <h2 class="mx-auto">Graceful Glam</h2>
        <p class="mx-auto">Discover Your Perfect Finds</p>
    </div>
  </div>

  <div class="container-fluid">
    <div class="container my-4">
      <!-- Recently Added -->
      <div class="row">
        <h4 class="mb-4 text-center">Recently Added Products</h4>
        <?php
        $query = "SELECT a.*, 
                (SELECT image_path FROM product_images WHERE product_id = a.id LIMIT 1) AS image_path,
                c.name AS 'category_name', 
                d.name AS 'subcategory_name'
              FROM products a
              INNER JOIN categories c ON a.category_id = c.id
              INNER JOIN subcategories d ON a.subcategory_id = d.id
              ORDER BY a.created_at DESC LIMIT 4";
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
        $index = 1;
        } else {
        echo "No product found.";
        }

        while ($product = mysqli_fetch_assoc($result)): 
        
        ?>
        <div class="col mt-2">
            <div class="card border-0">
              <a href="../../user/products/show.php?product_id=<?= $product['id'] ?>" class="text-decoration-none link-dark">
                <div class="zoom-container">
                  <img src="/admin<?= $product['image_path'] ?>" width="300" height="300" alt="<?= $product['name'] ?>" class="rounded">
                </div>
                <p class="fs-5 mt-4 mb-0"><?= $product['name'] ?></p>
                <p class="fs-5 text-secondary">RM <?= $product['price'] ?></p>
              </a>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>

    <!-- Footer -->
    <?php @include('layouts/footer.php') ?>

    <!-- Scripts -->
    <?php @include('layouts/scripts.php') ?> 
</body>

</html>