<?php
session_start();

require_once('../db_connectie.php');
require_once('../functies.php');

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

function annuleerBestelling($order_id) {
    $db = maakVerbinding();

    $sql1 = "DELETE FROM Pizza_Order_Product WHERE order_id = :order_id";
    $query1 = $db->prepare($sql1);
    $query1->execute(['order_id' => $order_id]);

    $sql2 = "DELETE FROM Pizza_Order WHERE order_id = :order_id";
    $query2 = $db->prepare($sql2);
    $query2->execute(['order_id' => $order_id]);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order_id'])) {
    annuleerBestelling($_POST['cancel_order_id']);
}

$bestellingen = haalBestellingenOp();

$statusLabels = [
    1 => "In de oven",
    2 => "Onderweg",
    3 => "Afgeleverd"
];

function toonBestelling($bestelling, $statusLabels) {
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

<?php include('../header.php'); ?>

    <h1>Profiel</h1>
    
    <h2>Bestellingen</h2>
    <?php if ($bestellingen): ?>
        <ul>
            <?php foreach ($bestellingen as $bestelling): ?>
                <?= toonBestelling($bestelling, $statusLabels); ?>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Je hebt geen bestellingen.</p>
    <?php endif; ?>
</body>
</html>

