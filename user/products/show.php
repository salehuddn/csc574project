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
              <div class="row mt-3">
                <div class="col-md-6">
                  <div id="carouselExampleIndicators" class="carousel carousel-dark slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                      <?php foreach ($images as $key => $image) { ?>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $key; ?>" <?php echo $key === 0 ? 'class="active" aria-current="true"' : ''; ?> aria-label="Slide <?php echo $key + 1; ?>"></button>
                      <?php } ?>
                    </div>
                    <div class="carousel-inner">
                      <?php foreach ($images as $image) { ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                          <img src="../../admin/<?php echo $image['image_path']; ?>" alt="Image <?php echo $index + 1; ?>" class="d-block mx-auto" width="550" height="550">
                        </div>
                        <?php $index++; ?>
                      <?php } ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                  </div>
                </div>
                <div class="col-md-6">
                <h1 class="name"><?=$name?></h1>
                <span class="price text-muted fs-5 fw-semibold mb-4">
                    RM <?=$price?>
                </span>
                <form action="" method="post" class="row g-2 mt-4">
                  <div class="col-auto">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" max="<?=$quantity?>" required>
                  </div>
                  <div class="col-auto pt-4">
                    <input type="hidden" name="product_id" value="<?=$id?>">
                    <input type="submit" class="btn btn-primary" value="Add To Cart">
                  </div>
                </form>
                <div class="description mt-3">
                    <?=$description?>
                </div>
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