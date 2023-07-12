<?php
session_start();

// Check if user is logged in
$loggedIn = isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'];

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a href="#" class="logo"><img src="../images/logo-svg-2.svg" alt="GracefulGlam" width="20%"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" aria-current="page" href="/">Home</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            Categories
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Men</a></li>
            <li><a class="dropdown-item" href="#">Women</a></li>
          </ul>
        </li>
        <?php
          if ($loggedIn) {
              echo '<li class="nav-item"><a href="../pages/profile.php" class="nav-link">Profile</a></li>';
              echo '<li class="nav-item"><a href="../logout.php" class="nav-link">Logout</a></li>';
          } else {
              echo '<li class="nav-item"><a href="../login.php" class="nav-link">Login</a></li>';
          }
        ?>
        <li class="nav-item">
          <a href="" class="nav-link fs-5">
            <ion-icon name="cart-outline"></ion-icon>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>