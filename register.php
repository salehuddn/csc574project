<?php 
  require_once 'config/connection.php';

  // Handle register form submission
  if (isset($_POST['register'])) {
    $name = $_POST['userName'];
    $email = $_POST['userEmail'];
    $password = $_POST['userPassword'];
    
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Perform a database query to insert the new user
    $query = "INSERT INTO Users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";
    $result = mysqli_query($connection, $query);

    if ($result) {
      // Registration successful, log in the user
      // Store the user's email in a session variable
      $_SESSION['userEmail'] = $email;

      // Redirect to the login page with a success message
      header('Location: index.php?registration=success');
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
        <div class="col-md-8">
          <div class="card">
            <div class="card-header fw-bold text-center">Register</div>
            <div class="card-body">
              <form method="post" id="register-form">
                <?php if (isset($registerError)): ?>
                <div class="alert alert-danger"><?php echo $registerError; ?></div>
                <?php endif; ?>

                <div class="mb-3">
                  <label for="name" class="form-label">Name: </label>
                  <input type="text" class="form-control" id="name" name="userName" required>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email: </label>
                  <input type="email" class="form-control" id="email" name="userEmail" required>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password: </label>
                  <input type="password" class="form-control" id="password" name="userPassword" required>
                </div>

                <div class="d-flex justify-content-end">
                  <button type="submit" class="btn btn-primary" name="register">Login</button>
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