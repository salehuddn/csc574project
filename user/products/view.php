<?php 
  require_once '../../config/connection.php';
  session_start();

  $category = $_GET['category'];
  $pageTitle = 'Products';
  $subcategory = $_GET['subcategory'] ?? '';

  if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'] || $_SESSION['role'] !== 'user') {
    header('Location: ../../login.php');
    exit();
  }

  require_once '../../user/queries/getProducts.php';
  require_once '../../user/queries/getSubCategories.php';
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
            <div class="card-header fw-bold text-center fs-4 bg-white"><?= $pageTitle ?></div>
            <div class="card-body">
              <div class="d-flex justify-content-between mb-3">
                <div class="">
                  <?=$totalProducts?> Products
                </div>
                <div></div>
                <div>
                  <select class="form-select" aria-label="Default select example" onchange="redirectToPage(this)">
                    <option selected disabled>Filter by Subcategory</option>
                    <?php
                    foreach ($subcategories as $subcategory):
                    ?>
                      <option value="<?=$subcategory['id']?>"><?=$subcategory['name']?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="container">
                <div class="row row-cols-md-4 row-cols-1">
                  <?php foreach ($products as $product): ?>
                    <div class="col mb-4">
                      <a href="../../user/products/show.php?product_id=<?=$product['id']?>" class="text-decoration-none">
                        <?php if (!empty($product['image_path'])) : ?>
                          <img src="../../../admin/<?=$product['image_path']?>" width="250" height="250" alt="<?=$product['name']?>" class="rounded">
                        <?php else : ?>
                          <img src="../../images/no-image-2.png" width="250" height="250" alt="<?=$product['name']?>" class="rounded">
                        <?php endif; ?>
                        <p class="text-dark mb-0 mt-1"><?=$product['name']?></p>
                      </a>
                      <p class="text-muted">RM <?=$product['price']?></p>
                    </div>
                  <?php endforeach; ?>
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
    <script>
        function redirectToPage(selectElement) {
          // Get the selected value from the <select> element
          var selectedValue = selectElement.value;
          
          // Check if the selected value is valid (not the default disabled option)
          if (selectedValue !== "") {
              // Get the 'category' parameter from the current URL using PHP
              var categoryParam = "<?php echo $_GET['category']; ?>";
              
              // Replace "YOUR_PAGE_URL" with the actual URL where you want to redirect the user
              var redirectURL = "../../user/products/view.php?category=" + categoryParam + "&subcategory=" + encodeURIComponent(selectedValue);
              
              // Redirect the user to the specified page
              window.location.href = redirectURL;
          }
      }
    </script>
</body>

</html>