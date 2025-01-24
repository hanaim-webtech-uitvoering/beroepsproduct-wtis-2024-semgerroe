<?php
session_start();

require_once('../db_connectie.php');
require_once('../functies.php');


function haalWinkelwagenDetailsOp() {
    $totalPrice = 0;
    $cartItems = [];

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product_name => $quantity) {
            $product = haalProductInfoOp($product_name);
            if ($product) {
                $totalPrice += $product['price'] * $quantity;
                $cartItems[] = ['name' => $product_name, 'quantity' => $quantity, 'price' => $product['price']];
            }
        }
    }

    return ['totalPrice' => $totalPrice, 'cartItems' => $cartItems];
}

function verwijderItemUitWinkelwagen($productName) {
    if (isset($_SESSION['cart'][$productName])) {
        $_SESSION['cart'][$productName]--;
        
        if ($_SESSION['cart'][$productName] <= 0) {
            unset($_SESSION['cart'][$productName]);
        }

        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    }
}


function toonWinkelwagenItem($item) {
    echo "<li>";
    echo htmlspecialchars($item['name']) . " - €" . number_format($item['price'], 2, ',', '.') . " x " . $item['quantity'];
    
    echo "<form method='post' action='' style='display:inline; margin-left:10px;'>
            <input type='hidden' name='remove_item' value='" . htmlspecialchars($item['name']) . "'>
            <button type='submit'>Verwijderen</button>
          </form>";

    echo "<form method='post' action='' style='display:inline; margin-left:10px;'>
            <input type='hidden' name='add_item' value='" . htmlspecialchars($item['name']) . "'>
            <button type='submit'>Toevoegen</button>
          </form>";
    echo "</li>";
}

function toonWinkelwagenItems($cartItems) {
    if ($cartItems) {
        foreach ($cartItems as $item) {
            toonWinkelwagenItem($item);
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

function toonBetaalKnop($cartItems) {
    if (count($cartItems) > 0) {
        return '<button type="submit">Betalen</button>';
    } else {
        return '<p>Je winkelwagen is leeg. Voeg producten toe om te betalen.</p>';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_item'])) {
        verwijderItemUitWinkelwagen($_POST['remove_item']);
    } elseif (isset($_POST['add_item'])) {
        voegExtraProductToe($_POST['add_item']);
    }
}


// Haal winkelwagengegevens op
$winkelwagenDetails = haalWinkelwagenDetailsOp();
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

<?php include('../header.php'); ?>

<h1>Winkelmandje</h1>

<ul id="cart-items">
    <?php toonWinkelwagenItems($cartItems); ?>
</ul>

<p id="total-price">Totale prijs: €<?= number_format($totalPrice, 2, ',', '.') ?></p>

<form method="post" action="betalen.php">
    <?php echo toonBetaalKnop($cartItems); ?>
</form>

</body>
</html>
