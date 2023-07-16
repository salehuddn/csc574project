<?php 
  require_once('../config/connection.php');
  session_start();
  
  if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('Location: ../../login.php');
    exit();
  }

  //retrieve user information
  $userId = $_SESSION['userId'];
  $query = "SELECT * FROM users WHERE id = $userId";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $email = $row['email'];
    $address = $row['address'];
    $city = $row['city'];
    $state = $row['state'];
    $zip_code = $row['zip_code'];
  } else {
    echo "Error";
  }

  if (isset($_POST['profile'])) {
    $newName = $_POST['userName'];
    $newEmail = $_POST['userEmail'];
  
    //update user's profile
    $query = "UPDATE users SET name = '$newName', email = '$newEmail' WHERE id = $userId";
    $updateResult = mysqli_query($connection, $query);
  
    if ($updateResult) {
      //update success
      $name = $newName;
      $email = $newEmail;
      $profileSuccess = "Profile updated successfully.";
    } else {
      $editProfileError = "Error updating profile.";
    }
  }
  
  if (isset($_POST['address'])) {
    $newAddress = $_POST['userAddress'];
    $newCity = $_POST['userCity'];
    $newState = $_POST['userState'];
    $newZipCode = $_POST['userZipCode'];
  
    //update user's address
    $query = "UPDATE users SET address = '$newAddress', city = '$newCity', state = '$newState', zip_code = '$newZipCode' WHERE id = $userId";
    $updateResult = mysqli_query($connection, $query);
  
    if ($updateResult) {
      //update success
      $address = $newAddress;
      $city = $newCity;
      $state = $newState;
      $zip_code = $newZipCode;
      $addressSuccess = "Address updated successfully.";
    } else {
      $editAddressError = "Error updating address.";
    }
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
      <?php @include('navbar.php'); ?>
    </div>
  </div>

  <div class="container-fluid">
    <div class="container my-4">
      <div class="row justify-content-center my-4">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header fw-bold text-center">Profile</div>
              <div class="card-body">

                <?php if (isset($profileSuccess)): ?>
                  <div class="alert alert-success"><?php echo $profileSuccess; ?></div>
                <?php endif; ?>
                <?php if (isset($editProfileError)): ?>
                  <div class="alert alert-danger"><?php echo $editProfileError; ?></div>
                <?php endif; ?>

                <form method="post" id="profile-form">
                  <?php if (isset($editProfileError)): ?>
                  <div class="alert alert-danger"><?php echo $editProfileError; ?></div>
                  <?php endif; ?>
                  
                  <div class="mb-3">
                    <label for="name" class="form-label">Name: </label>
                    <input type="text" class="form-control" id="userName" name="userName" value="<?php echo $name; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email: </label>
                    <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?php echo $email; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password: </label>
                    <input type="password" class="form-control" id="userPassword" name="userPassword">
                  </div>

                  <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success" name="profile">Save</button>
                  </div>
                </form>

              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header fw-bold text-center">Billing Address</div>
              <div class="card-body">

                <?php if (isset($addressSuccess)): ?>
                  <div class="alert alert-success"><?php echo $addressSuccess; ?></div>
                <?php endif; ?>
                <?php if (isset($editAddressError)): ?>
                  <div class="alert alert-danger"><?php echo $editAddressError; ?></div>
                <?php endif; ?>

                <form method="post" id="address-form">
                  <div class="mb-3">
                    <label for="address" class="form-label">Address: </label>
                    <input type="text" class="form-control" id="userAddress" name="userAddress" value="<?php echo $address ?? ''; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="city" class="form-label">City: </label>
                    <input type="text" class="form-control" id="userCity" name="userCity" value="<?php echo $city ?? ''; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="state" class="form-label">State: </label>
                    <input type="text" class="form-control" id="userState" name="userState" value="<?php echo $state ?? ''; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="zipcode" class="form-label">Zip Code: </label>
                    <input type="text" class="form-control" id="userZipCode" name="userZipCode" value="<?php echo $zip_code ?? ''; ?>">
                  </div>

                  <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success" name="address">Save</button>
                  </div>
                </form>

              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <?php @include('../layouts/footer.php') ?>
  <!-- Scripts -->
  <?php @include('../layouts/scripts.php') ?>
  <script>
  setActiveNavItem();
  </script>
</body>

</html>