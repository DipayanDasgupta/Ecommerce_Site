<?php
session_start();
include 'db.php';

if (isset($_POST['update_quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    if ($quantity == 0) {
        unset($_SESSION['cart'][$productId]);
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Your Cart</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="checkout.php">Checkout</a>
        </nav>
    </header>

    <main>
        <?php if (!empty($_SESSION['cart'])) { ?>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                <?php
                $totalPrice = 0;
                foreach ($_SESSION['cart'] as $productId => $quantity) {
                    $productQuery = "SELECT * FROM products WHERE id = $productId";
                    $productResult = $conn->query($productQuery);
                    if ($productResult->num_rows > 0) {
                        $product = $productResult->fetch_assoc();
                        $price = $product['price'] * $quantity;
                        $totalPrice += $price;
                        ?>
                        <tr>
                            <td><?php echo $product['name']; ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                    <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="0">
                                    <button type="submit" name="update_quantity">Update</button>
                                </form>
                            </td>
                            <td>₹<?php echo $price; ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                    <button type="submit" name="update_quantity" value="0">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <tr>
                    <td colspan="2">Total</td>
                    <td colspan="2">₹<?php echo $totalPrice; ?></td>
                </tr>
            </table>
        <?php } else { ?>
            <p>Your cart is empty.</p>
        <?php } ?>
    </main>
</body>
</html>
