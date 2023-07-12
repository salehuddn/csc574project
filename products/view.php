<?php 
  require_once '../config/connection.php';
  session_start();
  
  $email = $password = $name = '';

  if (isset($_SESSION['registerMessage'])) {
    $registerMessage = $_SESSION['registerMessage'];

    //unset the register message in the session
    unset($_SESSION['registerMessage']);

    //display the register message as alert
    echo '<script>window.alert("' . $registerMessage . '");</script>';
  }

  if (isset($_POST['login'])) {
    $email = $_POST['userEmail'];
    $password = $_POST['userPassword'];

    $query = "SELECT id, password FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $userId = $row['id'];
        $hashedPassword = $row['password'];

        //verify password
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['userId'] = $userId; //store the user's ID in the session
            $_SESSION['role'] = $role;

            $_SESSION['loginMessage'] = "Logged in successfully.";
            header('Location: index.php');
            exit();
        } else {
            $loginError = "Invalid email or password.";
        }
    } else {
        $loginError = "Invalid email or password.";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GracefulGlam | Products</title>

  <?php @include('../layouts/header.php') ?>
</head>

<body>
  <div class="container-fluid bg-dark">
    <div class="container">
      <?php @include('../layouts/navbar.php'); ?>
    </div>
  </div>

  <div class="container-fluid">
    <div class="container my-4">
      <div class="row justify-content-center my-4">
        <div class="col-lg-12 col-md-6 col-sm-6">
          <div class="card">
            <div class="card-header fw-bold text-center">Products</div>
            <div class="card-body">
              <!-- Add Product Button -->
              <div class="d-flex justify-content-end mb-3">
                <a href="../products/create.php" class="btn btn-primary">Add Product</a>
              </div>

              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead class="border">
                    <tr class="table-light">
                      <th scope="col">Name</th>
                      <th scope="col">Category</th>
                      <th scope="col">Price</th>
                      <th scope="col">Stock</th>
                      <th scope="col">Sold</th>
                      <th scope="col" class="text-center" width="10%">Action</th>
                    </tr>
                  </thead>
                  <tbody class="border">
                      <?php
                        require('../queries/getProducts.php');

                        if ($result && mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                            $name = $row['name'];
                            $category = $row['category_name'];
                            $subcategory = $row['subcategory_name'];
                            $price = $row['price'];
                            $stock = $row['stock'];
                            $sold = $row['sold'];
                      ?>
                      <tr class="border">
                        <td><?php echo $name ?? '' ?></td>
                        <td>
                          <?php echo $category ?? '' ?> | <?php echo $subcategory ?? '' ?>
                        </td>
                        <td><?php echo $price ?? '' ?></td>
                        <td><?php echo $stock ?? '' ?></td>
                        <td><?php echo $sold ?? '' ?></td>
                        <td class="text-center">
                          <a href="../products/show.php" class="text-dark"><ion-icon name="eye-outline"></ion-icon></a>
                          <a href="../products/create.php" class="text-dark"><ion-icon name="create-outline"></ion-icon></a>
                          <a href="../products/delete.php" class="text-dark"><ion-icon name="trash-outline"></ion-icon></a>
                        </td>
                      </tr>
                      <?php
                          }
                        } else {
                          echo 'No data found';
                        }
                      ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php @include('../layouts/scripts.php') ?>
    <script>
    </script>
</body>

</html>