<?php
include 'db.php';

$sql = "SELECT id, name, price FROM products";
$result = $conn->query($sql);

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = [
        'id' => (int)$row['id'],
        'name' => $row['name'],
        'price' => (float)$row['price']
    ];
}

header('Content-Type: application/json');
echo json_encode($products);
?>
