<?php
session_start();

require_once('../db_connectie.php');
require_once('../functies.php');

if (!isGebruikerIngelogd()) {
    header('Location: loginpagina.php');
    exit;
}

function haalVolledigeNaamOp($username) {
    $db = maakVerbinding();
    $sql = "SELECT CONCAT(first_name, ' ', last_name) AS full_name FROM [User] WHERE username = :username";
    $query = $db->prepare($sql);
    $query->execute(['username' => $username]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['full_name'] ?? null;
}

function haalGebruikersnaamOp() {
    return $_SESSION['username']; 
}

function haalAdresOp($username) {
    $db = maakVerbinding();
    $sql = "SELECT address FROM [User] WHERE username = :username";
    $query = $db->prepare($sql);
    $query->execute(['username' => $username]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['address'] ?? '';
}


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

function haalOrderIdOp() {
    $db = maakVerbinding();
    $sql = "SELECT TOP 1 order_id FROM Pizza_Order ORDER BY order_id DESC";
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['order_id'] ?? null;
}

$username = $_SESSION['username'];
$cart = $_SESSION['cart'];

$address = haalAdresOp($username);

    function plaatsBestelling($db, $username, $fullName, $personnel_username, $address, $status) {
        $query = $db->prepare("INSERT INTO Pizza_Order (client_username, client_name, personnel_username, datetime, status, address) 
            VALUES (?, ?, ?, ?, ?, ?)");
        
        $currentDate = date('Y-m-d H:i:s');
        $query->execute([$username, $fullName, $personnel_username, $currentDate, $status, $address]);
        
        return haalOrderIdOp(); 
    }

    function geefBestellingDetailsDoor($db, $orderId, $cart) {
    foreach ($cart as $product_name => $quantity) {
        if ($quantity > 0) {
            $query = $db->prepare("INSERT INTO Pizza_Order_Product (order_id, product_name, quantity) VALUES (?, ?, ?)");
            $query->execute([$orderId, $product_name, $quantity]);
        } else {
            echo "Waarschuwing: Quantity voor product '$product_name' is ongeldig (moet groter dan 0 zijn).<br>";
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['address'])) {
    $address = $_POST['address'];
    $fullName = haalVolledigeNaamOp($username);
    $personnel_username = haalPersoneelGebruikersnaamOp();
    $status = 1;
    
    $db = maakVerbinding();
    
    $orderId = plaatsBestelling($db, $username, $fullName, $personnel_username, $address, $status);
    
    geefBestellingDetailsDoor($db, $orderId, $cart);
    
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
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<?php include('../header.php'); ?>

    <h1>Betalen</h1>
    <form method="POST" action="betalen.php">
        <label for="address">Adres:</label>
        <input type="text" id="address" name="address" required placeholder="straat 123, 1234 AB, Amsterdam"
               value="<?php echo htmlspecialchars($address); ?>"
               pattern="^[a-zA-Z\s]+ \d{1,4}, \d{4}\s?[A-Za-z]{2}, [a-zA-Z\s]+$" 
               title="Vul een geldig adres in (bijv. straat 123, 1234 AB, Amsterdam)">
        <button type="submit">Bevestig Bestelling</button>
    </form>
</body>
</html>
