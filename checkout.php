<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Here, you would process payment and order confirmation
    $_SESSION['cart'] = array();  // Empty the cart
    echo "Thank you for your purchase!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Checkout</h1>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Place Order</button>
    </form>
</body>
</html>
