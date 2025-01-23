<?php
session_start();

require_once('../db_connectie.php');
require_once('../functies.php');

// Haal bestellingen op uit de database
function haalBestellingenOp() {
    $db = maakVerbinding();
    $sql = "SELECT PO.order_id, PO.datetime, PO.status
            FROM Pizza_Order PO
            WHERE PO.client_username = :client_username
            ORDER BY PO.datetime DESC";

    $query = $db->prepare($sql);
    $query->execute(['client_username' => $_SESSION['username']]);
    $bestellingen = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($bestellingen as &$bestelling) {
        $sql = "SELECT product_name, quantity 
                FROM Pizza_Order_Product 
                WHERE order_id = :order_id";
        $query = $db->prepare($sql);
        $query->execute(['order_id' => $bestelling['order_id']]);
        $bestelling['producten'] = $query->fetchAll(PDO::FETCH_ASSOC);
    }

    return $bestellingen;
}

// Annuleer een bestelling
function annuleerBestelling($order_id) {
    $db = maakVerbinding();
    $sql = "DELETE FROM Pizza_Order_Product WHERE order_id = :order_id;
            DELETE FROM Pizza_Order WHERE order_id = :order_id;";
    $query = $db->prepare($sql);
    $query->execute(['order_id' => $order_id]);
}

// Annuleer bestelling bij POST-verzoek
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order_id'])) {
    annuleerBestelling($_POST['cancel_order_id']);
}

// Haal bestellingen op
$bestellingen = haalBestellingenOp();

// Vertalingen voor de status
$statusLabels = [
    1 => "In de oven",
    2 => "Onderweg",
    3 => "Afgeleverd"
];

// Functie om een bestelling in HTML te renderen
function renderBestelling($bestelling, $statusLabels) {
    $output = "<li>";
    $output .= "<strong>Bestelling ID:</strong> " . htmlspecialchars($bestelling['order_id']) . "<br>";
    $output .= "<strong>Datum:</strong> " . htmlspecialchars($bestelling['datetime']) . "<br>";
    $output .= "<strong>Status:</strong> " . ($statusLabels[$bestelling['status']] ?? "Onbekend") . "<br>";
    $output .= "<strong>Producten:</strong><ul>";

    foreach ($bestelling['producten'] as $product) {
        $output .= "<li>Naam: " . htmlspecialchars($product['product_name']) . 
                   ", Aantal: " . htmlspecialchars($product['quantity']) . "</li>";
    }

    $output .= "</ul>";

    if ($bestelling['status'] == 1) {
        $output .= "<form method='POST' action=''>";
        $output .= "<input type='hidden' name='cancel_order_id' value='" . htmlspecialchars($bestelling['order_id']) . "'>";
        $output .= "<button type='submit'>Annuleer Bestelling</button>";
        $output .= "</form>";
    }

    $output .= "</li>";

    return $output;
}
?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiel</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div id="login-status">
            <?php toonLoginStatus(true); ?>
        </div>
        <nav>
            <a href="menupagina.php" class="back-button"><- Terug naar het menu</a>
        </nav>
    </header>
    <h1>Profiel</h1>
    
    <h2>Bestellingen</h2>
    <?php if ($bestellingen): ?>
        <ul>
            <?php foreach ($bestellingen as $bestelling): ?>
                <?= renderBestelling($bestelling, $statusLabels); ?>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Je hebt geen bestellingen.</p>
    <?php endif; ?>
</body>
</html>

