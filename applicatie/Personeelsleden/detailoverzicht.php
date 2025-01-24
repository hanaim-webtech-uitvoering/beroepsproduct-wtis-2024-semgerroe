<?php 
session_start();

require_once('../db_connectie.php');
require_once('../functies.php');

if (!isGebruikerIngelogd() || $_SESSION['role'] != 'Personnel') {
    header("Location: ../toegang-geweigerd.php");
    exit();
}

$isIngelogd = isGebruikerIngelogd();

if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
    
    $bestelling = haalBestellingDetailsOp($verbinding, $order_id);
    $producten = haalProductenVanBestellingOp($verbinding, $order_id);
}

function haalBestellingDetailsOp($verbinding, $order_id) {
    $sql = "SELECT o.order_id, o.client_name, o.address, o.datetime, o.status
            FROM Pizza_Order o
            WHERE o.order_id = ?";
    
    $query = $verbinding->prepare($sql);
    $query->execute([$order_id]);
    return $query->fetch(PDO::FETCH_ASSOC);  
}

function haalProductenVanBestellingOp($verbinding, $order_id) {
    $sql = "SELECT p.product_name, p.quantity
            FROM Pizza_Order_Product p
            WHERE p.order_id = ?";
    
    $query = $verbinding->prepare($sql);
    $query->execute([$order_id]);
    $producten = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($producten as &$product) {
        $productInfo = haalProductInfoOp($product['product_name']);
        $product['price'] = $productInfo['price'];
    }
    return $producten;
}

function toonBestellingStatus($status) {
    if ($status == 1) {
        return "Aan het bereiden";
    } elseif ($status == 2) {
        return "Onderweg";
    } elseif ($status == 3) {
        return "Afgeleverd";
    } else {
        return "Status onbekend";
    }
}

function toonProducten($producten) {
    echo "<ul id='order-items'>";
    foreach ($producten as $product) {
        echo "<li>" . htmlspecialchars($product['quantity']) . "x " . htmlspecialchars($product['product_name']) . "</li>";
    }
    echo "</ul>";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailoverzicht Bestelling</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    <div id="login-status">
        <?php toonLoginStatus($isIngelogd); ?>
    </div>
    <nav>
            <a href="bestellingOverzicht.php" class="back-button"><- Terug naar alle bestellingen</a>
        </nav>
</header>

<h1>Detailoverzicht Bestelling</h1>

<?php if ($bestelling): ?>
    <p><strong>Bestelling ID:</strong> #<?= htmlspecialchars($bestelling['order_id']) ?></p>
    <p><strong>Naam klant:</strong> <?= htmlspecialchars($bestelling['client_name']) ?></p>
    <p><strong>Adres:</strong> <?= htmlspecialchars($bestelling['address']) ?></p>
    <p><strong>Besteld op:</strong> <?= htmlspecialchars($bestelling['datetime']) ?></p>

    <h2>Menu Items</h2>
    <?php toonProducten($producten); ?>

    <h2>Status</h2>
    <p><?= toonBestellingStatus($bestelling['status']); ?></p>
<?php else: ?>
    <p>Geen details gevonden voor deze bestelling.</p>
<?php endif; ?>

</body>
</html>
