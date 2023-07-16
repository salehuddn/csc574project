<?php 
  require_once('../../config/connection.php');
  session_start();
  
  if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'] || $_SESSION['role'] !== 'admin') {
    header('Location: ../../login.php');
    exit();
  }
  
  require_once('../queries/getCategoryById.php');
  require_once('../queries/updateCategoryById.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GracefulGlam | Edit Category</title>

  <?php @include('../../layouts/header.php') ?>
  <style>
    .required-field::after {
      content: " *";
      color: red;
      display: inline;
    }
  </style>
</head>

<body>
  <div class="container-fluid bg-dark">
    <div class="container">
      <?php @include('../../admin/navbar.php'); ?>
    </div>
  </div>

  <div class="container-fluid">
    <div class="container my-4">
      <div class="row justify-content-center my-4">
          <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card">
              <div class="card-header fw-bold text-center"><?php echo $pageTitle; ?></div>
              <div class="card-body">
                <?php if (isset($successMsg)) : ?>
                  <div class="alert alert-success"><?php echo $successMsg; ?></div>
                <?php endif; ?>
                <?php if (isset($errorMsg)) : ?>
                  <div class="alert alert-danger"><?php echo $errorMsg; ?></div>
                <?php endif; ?>

                <form method="post" id="category-form">
                    <div class="mb-3">
                        <label for="<?php echo $name ?>" class="form-label required-field"><?php echo $label ?> Name: </label>
                        <input type="text" class="form-control" id="<?php echo $name ?>" name="<?php echo $name ?>" value="<?php echo $name; ?>">
                    </div>
                    <input type="hidden" name="<?php echo $id; ?>" value="<?php echo $id; ?>">

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success px-4" name="submit">Save</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
      </div>
    </div>

    <?php @include('../../layouts/scripts.php') ?>
    <script>
    setActiveNavItem();
    </script>
</body>

</html>