<?php 
session_start();

require_once('../db_connectie.php');
require_once('../functies.php');

// Check of de gebruiker ingelogd is
$isIngelogd = isGebruikerIngelogd();

if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
    
    // Haal de details van deze bestelling op
    $bestelling = getBestellingDetails($verbinding, $order_id);
    $producten = getProductenVanBestelling($verbinding, $order_id);
}

// Functie om bestellinggegevens op te halen (zoals klantnaam, adres, totaalprijs en tijd)
function getBestellingDetails($verbinding, $order_id) {
    $sql = "SELECT o.order_id, o.client_name, o.address, o.datetime, o.status
            FROM Pizza_Order o
            WHERE o.order_id = ?";
    
    $stmt = $verbinding->prepare($sql);
    $stmt->execute([$order_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);  // Retourneer de details van de bestelling
}

// Functie om de producten van een bestelling op te halen
function getProductenVanBestelling($verbinding, $order_id) {
    $sql = "SELECT p.product_name, p.quantity
            FROM Pizza_Order_Product p
            WHERE p.order_id = ?";
    
    $stmt = $verbinding->prepare($sql);
    $stmt->execute([$order_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Retourneer een lijst van producten voor deze bestelling
}
?>

<!-- Detailoverzicht Bestelling Page (PE-02) -->
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
    <ul id="order-items">
        <?php foreach ($producten as $product): ?>
            <li><?= htmlspecialchars($product['quantity']) ?>x <?= htmlspecialchars($product['product_name']) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Status</h2>
    <p>
        <?php 
            // Weergeef de status van de bestelling op basis van de waarde van `status` in de database met if-else
            if ($bestelling['status'] == 1) {
                echo "Aan het bereiden";
            } elseif ($bestelling['status'] == 2) {
                echo "Onderweg";
            } elseif ($bestelling['status'] == 3) {
                echo "Afgeleverd";
            } else {
                echo "Status onbekend";
            }
        ?>
    </p>
<?php else: ?>
    <p>Geen details gevonden voor deze bestelling.</p>
<?php endif; ?>

</body>
</html>
