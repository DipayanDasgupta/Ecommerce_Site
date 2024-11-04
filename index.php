<?php
include 'db.php';

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple E-commerce</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/scripts.js" defer></script>
</head>
<body>

    <!-- Header Section -->
    <header>
        <h1>Our E-commerce Store</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="cart.php">Cart (<span id="cart-count">0</span>)</a>
        </nav>
    </header>

    <!-- Product Listing Section -->
    <main>
        <h2>Featured Products</h2>
        <div class="product-list">
            <?php if ($result->num_rows > 0) { ?>
                <?php while($row = $result->fetch_assoc()) { ?>
                    <div class="product">
                        <img src="<?php echo $row['image'] ?: 'images/placeholder.jpg'; ?>" alt="<?php echo $row['name']; ?> Image">
                        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <p>Price: $<?php echo number_format($row['price'], 2); ?></p>
                        <button onclick="addToCart(<?php echo $row['id']; ?>)">Add to Cart</button>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No products available.</p>
            <?php } ?>
        </div>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 E-commerce Site. All rights reserved.</p>
    </footer>

</body>
</html>
