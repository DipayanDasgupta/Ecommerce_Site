<?php
session_start();
include 'db.php';

// Check if cart is empty
if (empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. <a href='index.php'>Continue Shopping</a></p>";
    exit();
}

// Calculate total price of items in the cart
$totalPrice = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

// Handle form submission for checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Here, integrate payment processing and store order details in the database

    // Clear the cart after successful checkout
    $_SESSION['cart'] = array();
    echo "<div class='confirmation'>
            <h2>Thank you for your purchase!</h2>
            <p>Your order has been successfully placed and will be processed shortly.</p>
            <a href='index.php'>Return to Home</a>
          </div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Styling specific to the checkout page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header, .confirmation {
            background-color: #2b2b52;
            color: white;
            padding: 1em;
            text-align: center;
            width: 100%;
            margin-bottom: 20px;
        }

        h1, h2 {
            margin-bottom: 15px;
        }

        main {
            display: flex;
            gap: 30px;
            width: 80%;
            max-width: 1000px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        .order-summary, .checkout-form {
            width: 100%;
        }

        .order-summary table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .order-summary th, .order-summary td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .total-price {
            font-size: 1.3em;
            font-weight: bold;
            text-align: right;
        }

        .checkout-form .form-group {
            margin-bottom: 15px;
        }

        .checkout-form input, .checkout-form textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }

        .checkout-form .submit-btn {
            background-color: #ff686b;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .checkout-form .submit-btn:hover {
            background-color: #ff5155;
        }

        .confirmation {
            color: #2b2b52;
            font-size: 1.2em;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            main {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Checkout</h1>
</header>

<main>
    <section class="order-summary">
        <h2>Order Summary</h2>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price (INR)</th>
                    <th>Total Price (INR)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p class="total-price">Total: INR <?php echo number_format($totalPrice, 2); ?></p>
    </section>

    <section class="checkout-form">
        <h2>Shipping Details</h2>
        <form method="POST" action="" onsubmit="return confirm('Do you want to place this order?');">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="address">Shipping Address:</label>
                <textarea id="address" name="address" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" placeholder="10-digit number" required>
            </div>

            <button type="submit" class="submit-btn">Place Order</button>
        </form>
    </section>
</main>

</body>
</html>
