<?php
require_once '../../config/connection.php';

if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'] || $_SESSION['role'] !== 'user') {
    unset($_SESSION['cart']);
    header('Location: ../../login.php');
    exit();
}

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Get the user ID from the session
    $user_id = $_SESSION['userId'];

    // Calculate the subtotal
    $subtotal = 0;
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        // Retrieve the product price from the database
        $stmt = $connection->prepare('SELECT price FROM products WHERE id = ?');
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        // Calculate the item total
        $item_total = $product['price'] * $quantity;
        $subtotal += $item_total;
    }

    // Insert the order into the database
    $stmt = $connection->prepare('INSERT INTO orders (user_id, total_amount) VALUES (?, ?)');
    $stmt->bind_param('id', $user_id, $subtotal);
    $stmt->execute();

    // Get the order ID of the inserted order
    $order_id = $stmt->insert_id;

    // Insert the order items into the database
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        // Retrieve the product price from the database
        $stmt = $connection->prepare('SELECT price FROM products WHERE id = ?');
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        // Insert the order item into the database
        $stmt = $connection->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('iiid', $order_id, $product_id, $quantity, $product['price']);
        $stmt->execute();
    }

    // Clear the cart after placing the order
    unset($_SESSION['cart']);
}

// Redirect the user to a success page or any other desired page
header('Location: ../../user/products/placeorder.php');
exit();
