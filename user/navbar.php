<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a href="#" class="logo"><img src="../../images/logo-svg-2.svg" alt="GracefulGlam" width="20%"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" aria-current="page" href="../../user/index.php">Home</a></li>
        <!-- <li class="nav-item"><a href="../../user/products/view.php" class="nav-link">Products</a></li> -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            Products
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php 
              $query = "SELECT * FROM categories";
              $result = mysqli_query($connection, $query);
              if ($result && mysqli_num_rows($result) > 0) {
                $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
              } else {
                echo "Error";
              }
              foreach ($categories as $category):
            ?>
              <li>
                <a class="dropdown-item" href="../../user/products/view.php?category=<?php echo $category['id'] ?>&subcategory="><?php echo $category['name'] ?></a>
              </li>
            <?php
              endforeach;
            ?>
            <li><a class="dropdown-item" href="../../user/products/view.php?category=all&subcategory=">All</a></li>
          </ul>
        </li>
        <li class="nav-item"><a href="../../user/orders/view.php" class="nav-link">Orders</a></li>
        <li class="nav-item"><a href="../../user/profile.php" class="nav-link">Profile</a></li>
        <li class="nav-item"><a href="../../logout.php" class="nav-link">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>