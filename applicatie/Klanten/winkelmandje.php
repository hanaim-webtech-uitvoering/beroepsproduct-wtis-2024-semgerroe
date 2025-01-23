<?php
session_start();

// Include de databaseverbinding
require_once('../db_connectie.php');
require_once('../functies.php');

// Bereken het totaalbedrag en haal de winkelwagenitems op
function haalWinkelwagenDetails() {
    $totalPrice = 0;
    $cartItems = [];

    if (isset($_SESSION['cart'])) {
        $db = maakVerbinding();
        foreach ($_SESSION['cart'] as $product_name => $quantity) {
            $sql = "SELECT price FROM Product WHERE name = :product_name";
            $stmt = $db->prepare($sql);
            $stmt->execute(['product_name' => $product_name]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                $totalPrice += $product['price'] * $quantity;
                $cartItems[] = ['name' => $product_name, 'quantity' => $quantity, 'price' => $product['price']];
            }
        }
    }

    return ['totalPrice' => $totalPrice, 'cartItems' => $cartItems];
}

// Verwijder een item uit de winkelwagen
function verwijderItemUitWinkelwagen($removeItem) {
    if (isset($_SESSION['cart'][$removeItem])) {
        unset($_SESSION['cart'][$removeItem]);
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    }
}

// Render de winkelwagenitems
function renderWinkelwagenItems($cartItems) {
    if ($cartItems) {
        foreach ($cartItems as $item) {
            echo "<li>";
            echo htmlspecialchars($item['name']) . " - €" . number_format($item['price'], 2, ',', '.') . " x " . $item['quantity'];
            
            // Add a "Delete" button
            echo "<form method='post' action='' style='display:inline; margin-left:10px;'>";
            echo "<input type='hidden' name='remove_item' value='" . htmlspecialchars($item['name']) . "'>";
            echo "<button type='submit'>Verwijderen</button>";
            echo "</form>";
            
            // Add an "Add" button
            echo "<form method='post' action='' style='display:inline; margin-left:10px;'>";
            echo "<input type='hidden' name='add_item' value='" . htmlspecialchars($item['name']) . "'>";
            echo "<button type='submit'>Toevoegen</button>";
            echo "</form>";
            
            echo "</li>";
        }
    } else {
        echo "<li>Geen items in het winkelmandje.</li>";
    }
}

function voegExtraProductToe($productName) {
    if (isset($_SESSION['cart'][$productName])) {
        $_SESSION['cart'][$productName]++;
    }
}


// Verwerk POST-aanvragen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_item'])) {
        verwijderItemUitWinkelwagen($_POST['remove_item']);
    } elseif (isset($_POST['add_item'])) {
        voegExtraProductToe($_POST['add_item']);
    }
}


// Haal winkelwagengegevens op
$winkelwagenDetails = haalWinkelwagenDetails();
$isIngelogd = isGebruikerIngelogd();
$cartItems = $winkelwagenDetails['cartItems'];
$totalPrice = $winkelwagenDetails['totalPrice'];
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
<header>
    <div id="login-status">
        <?php toonLoginStatus($isIngelogd); ?>
    </div>
    <nav>
            <a href="menupagina.php" class="back-button"><- Terug naar het menu</a>
        </nav>
</header>

<h1>Winkelmandje</h1>

<ul id="cart-items">
    <?php renderWinkelwagenItems($cartItems); ?>
</ul>

<p id="total-price">Totale prijs: €<?= number_format($totalPrice, 2, ',', '.') ?></p>

<form method="post" action="betalen.php">
    <button type="submit">Betalen</button>
</form>
</body>
</html>
