<?php
session_start();
include 'db.php';

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Initialize cart session if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Function to add product to the cart
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 1; // Initial quantity
    } else {
        $_SESSION['cart'][$productId]++; // Increment quantity
    }
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple E-commerce</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Our E-commerce Store</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="cart.php">Cart (<?php echo array_sum($_SESSION['cart']); ?>)</a>
        </nav>
    </header>

    <main>
        <h2>Featured Products</h2>
        <div class="product-list">
            <?php if ($result->num_rows > 0) { ?>
                <?php while($row = $result->fetch_assoc()) { ?>
                    <div class="product">
                        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?> Image">
                        <h3><?php echo $row['name']; ?></h3>
                        <p><?php echo $row['description']; ?></p>
                        <p>Price: ₹<?php echo $row['price']; ?></p>
                        <form method="POST" action="">
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="add_to_cart">Add to Cart</button>
                        </form>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No products available.</p>
            <?php } ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 E-commerce Site. All rights reserved.</p>
    </footer>
</body>
</html>
