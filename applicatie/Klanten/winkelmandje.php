<?php
// Include de databaseverbinding
require_once('../db_connectie.php');

// Start sessie om winkelmandje op te halen
session_start();
$totalPrice = 0;
$cartItems = [];

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_name => $quantity) {
        // Haal productprijs op uit de database
        $sql = "SELECT price FROM Product WHERE name = :product_name";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(['product_name' => $product_name]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $totalPrice += $product['price'] * $quantity;
            $cartItems[] = ['name' => $product_name, 'quantity' => $quantity, 'price' => $product['price']];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelmandje</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Winkelmandje</h1>
    <ul id="cart-items">
        <?php
        if ($cartItems) {
            foreach ($cartItems as $item) {
                echo "<li>{$item['name']} - €" . number_format($item['price'], 2, ',', '.') . " x {$item['quantity']}</li>";
            }
        } else {
            echo "<li>Geen items in het winkelmandje.</li>";
        }
        ?>
    </ul>
    <p id="total-price">Totale prijs: €<?php echo number_format($totalPrice, 2, ',', '.'); ?></p>
    <button id="confirm-order">Bevestig Bestelling</button>
</body>
</html>
