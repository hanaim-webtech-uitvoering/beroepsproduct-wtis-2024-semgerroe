<?php
session_start();

require_once('../db_connectie.php');
require_once('../functies.php');

// Controleer of de gebruiker is ingelogd
if (!isGebruikerIngelogd()) {
    header('Location: loginpagina.php');
    exit;
}

// Haal klantgegevens op
function haalVolledigeNaamOp($username) {
    $db = maakVerbinding();
    $sql = "SELECT CONCAT(first_name, ' ', last_name) AS full_name FROM [User] WHERE username = :username";
    $query = $db->prepare($sql);
    $query->execute(['username' => $username]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['full_name'] ?? null;
}

// Haal personeelsgegevens op
function haalPersoneelGebruikersnaamOp() {
    $db = maakVerbinding();
    $sql = "SELECT TOP 1 username 
            FROM [User] 
            WHERE role = 'Personnel' 
            ORDER BY NEWID();";
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['username'] ?? null;
}

// Haal laatste order_id op
function haalOrderIdOp() {
    $db = maakVerbinding();
    $sql = "SELECT TOP 1 order_id FROM Pizza_Order ORDER BY order_id DESC";
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['order_id'] ?? null;
}

$username = $_SESSION['username'];
$cart = $_SESSION['cart']; // ['product_name' => 'quantity']

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['address'])) {
    $address = $_POST['address'];
    $fullName = haalVolledigeNaamOp($username);
    $personnel_username = haalPersoneelGebruikersnaamOp();
    $status = 1;

    // Voeg nieuwe bestelling toe aan Pizza_Order
    $db = maakVerbinding();
    $query = $db->prepare("INSERT INTO Pizza_Order (client_username, client_name, personnel_username, datetime, status, address) 
        VALUES (?, ?, ?, ?, ?, ?)");

    $currentDate = date('Y-m-d H:i:s');
    $query->execute([$username, $fullName, $personnel_username, $currentDate, $status, $address]);

    // Haal het laatst ingevoegde order_id op
    $orderId = haalOrderIdOp();

    // Voeg de producten van de bestelling toe
    foreach ($cart as $product_name => $quantity) {
        $query = $db->prepare("INSERT INTO Pizza_Order_Product (order_id, product_name, quantity) VALUES (?, ?, ?)");
        $query->execute([$orderId, $product_name, $quantity]);
    }

    // Winkelmandje legen
    $_SESSION['cart'] = [];
    echo "Bestelling succesvol geplaatst!";

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Betalen</title>
</head>
<body>
    <h1>Betalen</h1>
    <form method="POST" action="betalen.php">
        <label for="address">Bezorgadres:</label>
        <textarea 
            name="address" 
            id="address" 
            required 
            placeholder="Bijvoorbeeld: Voorbeeldstraat 123, 1234 AB, Amsterdam"
            pattern="^[a-zA-Z\s]+ \d{1,5}, \d{4} [A-Z]{2}, [a-zA-Z\s]+$"
            title="Gebruik het formaat: Straatnaam en huisnummer, postcode, Stadsnaam"></textarea>
        <button type="submit">Bevestig Bestelling</button>
    </form>
</body>
</html>

