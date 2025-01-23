<?php
// Start de sessie
session_start();

// Include de databaseverbinding
require_once('../db_connectie.php');
require_once('../functies.php');

// Voeg een product toe aan de winkelwagen
function voegProductToeAanWinkelwagen($productName) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$productName])) {
        $_SESSION['cart'][$productName]++;
    } else {
        $_SESSION['cart'][$productName] = 1;
    }
}

// Haal producten op uit de database
function haalProductenOp() {
    $db = maakVerbinding();
    $sql = "SELECT name, price, type_id FROM Product ORDER BY type_id, name";
    $query = $db->prepare($sql);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Toon producten in HTML-lijst
function toonProducten($producten) {
    if ($producten) {
        foreach ($producten as $product) {
            echo "<li>";
            echo "<h2>" . htmlspecialchars($product['name']) . "</h2>";
            echo "<p>Prijs: €" . number_format($product['price'], 2, ',', '.') . "</p>";
            echo "<p>Type: " . htmlspecialchars($product['type_id']) . "</p>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='product_name' value='" . htmlspecialchars($product['name']) . "'>";
            echo "<button type='submit'>Toevoegen</button>";
            echo "</form>";
            echo "</li>";
        }
    } else {
        echo "<li>Geen producten beschikbaar</li>";
    }
}

// Hoofdlogica
$isIngelogd = isGebruikerIngelogd();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_name'])) {
    voegProductToeAanWinkelwagen($_POST['product_name']);
}
$producten = haalProductenOp();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    <div id="login-status">
        <?php toonLoginStatus($isIngelogd); ?>
    </div>
    <div id="header-icons">
        <!-- Winkelmand -->
        <div id="shopping-cart">
            <a href="winkelmandje.php">
                <img src="../images/cart.png" alt="Winkelmand" />
                <span id="cart-count">
                    <?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>
                </span>
            </a>
        </div>
        
        <!-- Profiel -->
        <?php if ($isIngelogd): ?>
        <div id="profile">
            <a href="profielpagina.php">
                <img src="../images/profile-icon.png" alt="Profiel" />
            </a>
        </div>
        <?php endif; ?>
    </div>
</header>

<h1>Menu</h1>
<ul id="menu-items">
    <?php toonProducten($producten); ?>
</ul>
</body>
</html>
