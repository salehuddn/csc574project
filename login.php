<?php 
  require_once 'config/connection.php';
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

    $query = "SELECT id, password, role FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $userId = $row['id'];
        $hashedPassword = $row['password'];
        $role = $row['role'];

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
  <title>GracefulGlam | Login</title>

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
        <div class="col-lg-4 col-md-4 col-sm-6">
          <div class="card">
            <div class="card-header fw-bold text-center">Login</div>
            <div class="card-body">
              <form method="post" id="login-form">
                <?php if (isset($loginError)): ?>
                <div class="alert alert-danger"><?php echo $loginError; ?></div>
                <?php endif; ?>

                <div class="mb-3">
                  <label for="email" class="form-label">Email: </label>
                  <input type="email" class="form-control" id="email" name="userEmail" value="<?php echo $email; ?>">
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password: </label>
                  <input type="password" class="form-control" id="password" name="userPassword" required>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                  <button type="submit" class="btn btn-success" name="login">Login</button>
                </div>

                <div class="d-flex justify-content-center">
                  <p class="text-muted mt-2">Don't have an account yet? <a href="register.php" class="text-decoration-none">Sign up</a></p>
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