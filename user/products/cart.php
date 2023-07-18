<?php 
  require_once '../../config/connection.php';
  session_start();

  $pageTitle = 'Carts';

  if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'] || $_SESSION['role'] !== 'user') {
    unset($_SESSION['cart']);
    header('Location: ../../login.php');
    exit();
  }

  if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    // Set the post variables so we easily identify them, also make sure they are integers
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    // Prepare the SQL statement, we basically are checking if the product exists in our database
    $stmt = $connection->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->bind_param('i', $_POST['product_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) {
        // Product exists in the database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in the cart, so just update the quantity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Product is not in the cart, so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            // There are no products in the cart, this will add the first product to the cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    // Prevent form resubmission...
    header('location: ../../user/products/cart.php');
    exit;
  }

  // Remove product from the cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
  if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
  }

  // Update product quantities in the cart if the user clicks the "Update" button on the shopping cart page
  if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in the cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update the new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    // Prevent form resubmission...
    header('location: ../../user/products/cart.php');
    exit;
  }

  // Send the user to the place order page if they click the "Place Order" button, and the cart should not be empty
  if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: ../../user/products/placeorder.php');
    exit;
  }

  // Check the session variable for products in the cart
  $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
  $products = array();
  $subtotal = 0.00;
  // If there are products in the cart
  if ($products_in_cart) {
      // There are products in the cart, so we need to select those products from the database
      // Products in cart array to a question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
      $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
      $stmt = $connection->prepare('
        SELECT a.*,
        (SELECT image_path FROM product_images WHERE product_id = a.id LIMIT 1) AS image_path
        FROM products a
        WHERE a.id IN (' . $array_to_question_marks . ')
    ');

      $stmt->bind_param(str_repeat('i', count($products_in_cart)), ...array_keys($products_in_cart));
      $stmt->execute();
      $result = $stmt->get_result();
      $products = $result->fetch_all(MYSQLI_ASSOC);
      // Calculate the subtotal
      foreach ($products as $product) {
          $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['id']];
      }
  }

  // Function to remove a product from the cart
  function removeProductFromCart($product_id)
  {
      if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$product_id])) {
          unset($_SESSION['cart'][$product_id]);
      }
  }

  // Check if the "remove" parameter is set and call the remove function
  if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
      $product_id_to_remove = $_GET['remove'];
      removeProductFromCart($product_id_to_remove);
  }

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
            <div class="card-header fw-bold text-center fs-4 bg-white border-0"><?= $pageTitle ?></div>
            <div class="card-body">
              <form action="../../user/products/cart.php" method="post">
                <table class="table align-middle">
                  <thead class="border-bottom">
                    <tr class="fw-normal">
                      <th colspan="2">Product</th>
                      <th>Price</th>
                      <th width=5%>Quantity</th>
                      <th class="text-end">Total</th>
                    </tr>
                  </thead>
                  <tbody class="border-bottom">
                  <?php if (empty($products)): ?>
                  <tr>
                    <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                  </tr>
                  <?php else: ?>
                  <?php foreach ($products as $product): ?>
                  <tr>
                    <td class="img">
                      <a href="../../user/products/show.php?product_id=<?=$product['id']?>">
                        <?php if (!empty($product['image_path'])) : ?>
                          <img src="../../admin/<?=$product['image_path']?>" width="50" height="50" alt="<?=$product['name']?>">
                        <?php else : ?>
                          <img src="../../images/no-image-2.png" width="50" height="50" alt="<?=$product['name']?>">
                        <?php endif; ?>
                      </a>
                    </td>
                    <td>
                      <?=$product['name']?>
                      <br>
                      <small><a href="?remove=<?=$product['id']?>" class="link-secondary small text-decoration-none">Remove</a></small>
                    </td>
                    <td>RM <?=$product['price']?></td>
                    <td>
                      <input type="number" class="form-control quantity-input" min="1" max="<?=$product['stock']?>" name="quantity-<?=$product['id']?>" value="<?=$products_in_cart[$product['id']]?>" placeholder="Quantity" required>
                    </td>
                    <td class="text-end subtotal-cell">RM <?=$product['price'] * $products_in_cart[$product['id']]?></td>
                  </tr>
                  <?php endforeach; ?>
                  <?php endif; ?>
                  <tr>
                  <tr height="100px">
                    <td colspan="4" class="text-end fs-5">Subtotal</td>
                    <td class="text-end subtotal-cell">RM <?=$subtotal?></td>
                  </tr>
                </tbody>
                </table>
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" name="update" class="btn btn-secondary">Update Cart</button>
                    <button type="submit" name="placeorder" class="btn btn-success">Place Order</button>
                </div>
            </form>
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

    </script>
</body>

</html>