<?php 
  require_once('../config/connection.php');
  session_start();
  
  if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('Location: login.php');
    exit();
  }

  // Retrieve user information from the database
  $userId = $_SESSION['userId'];
  $query = "SELECT * FROM users WHERE id = $userId";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $email = $row['email'];
  } else {
    echo "Error";
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GracefulGlam | Profile</title>

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
        <div class="col-md-8">
          <div class="card">
            <div class="card-header fw-bold text-center">Profile</div>
            <div class="card-body">
              <table class="table">
                <tbody>
                  <tr>
                    <th scope="row">Name</th>
                    <td><?php echo $name; ?></td>
                  </tr>
                  <tr>
                    <th scope="row">Email</th>
                    <td><?php echo $email; ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php @include('../layouts/scripts.php') ?>
    <script>
    setActiveNavItem();
    </script>
</body>

</html>