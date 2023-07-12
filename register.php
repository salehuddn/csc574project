<?php 
  require_once 'config/connection.php';
  session_start();

  if (isset($_POST['register'])) {
    $name = $_POST['userName'];
    $email = $_POST['userEmail'];
    $password = $_POST['userPassword'];
    
    //hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    //insert the new user
    $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";
    $result = mysqli_query($connection, $query);

    if ($result) {
      $_SESSION['userEmail'] = $email;
      $_SESSION['registerMessage'] = "Registration successful! You can now log in.";

      header('Location: login.php');
      exit();
    } else {
        $registerError = "Error registering user.";
    }
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GracefulGlam | Register</title>

  <?php @include('layouts/header.php') ?>

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
      <?php @include('layouts/navbar.php'); ?>
    </div>
  </div>

  <div class="container-fluid">
    <div class="container my-4">
      <div class="row justify-content-center my-4">
        <div class="col-lg-4 col-md-4 col-sm-6">
          <div class="card">
            <div class="card-header fw-bold text-center">Register</div>
            <div class="card-body">
              <form method="post" id="register-form">
                <?php if (isset($registerError)): ?>
                <div class="alert alert-danger"><?php echo $registerError; ?></div>
                <?php endif; ?>

                <div class="mb-3">
                  <label for="name" class="form-label required-field">Name: </label>
                  <input type="text" class="form-control" id="name" name="userName" required>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label required-field">Email: </label>
                  <input type="email" class="form-control" id="email" name="userEmail" required>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label required-field">Password: </label>
                  <input type="password" class="form-control" id="password" name="userPassword" required>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                  <button type="submit" class="btn btn-success" name="register">Register</button>
                </div>

                <div class="d-flex justify-content-center">
                  <p class="text-muted mt-2">Already have an account? <a href="login.php" class="text-decoration-none">Log in</a></p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php @include('layouts/scripts.php') ?>
    <script>
    setActiveNavItem();
    </script>
</body>

</html>