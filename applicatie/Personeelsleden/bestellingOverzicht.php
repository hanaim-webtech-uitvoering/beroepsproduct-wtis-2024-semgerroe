<?php
session_start();

require_once('../db_connectie.php');
require_once('../functies.php');

if (!isGebruikerIngelogd() || $_SESSION['role'] != 'Personnel') {
    header("Location: ../toegang-geweigerd.php");
    exit();
}

function toonBestellingen($verbinding) {
    $sql = "SELECT o.order_id, o.client_name, o.status, o.address, p.product_name, p.quantity
            FROM Pizza_Order o
            LEFT JOIN Pizza_Order_Product p ON o.order_id = p.order_id
            ORDER BY o.status ASC, o.datetime ASC";
    
    $query = $verbinding->query($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function updateOrderStatus($verbinding, $order_id, $status) {
    $update_sql = "UPDATE Pizza_Order SET status = ? WHERE order_id = ?";
    $query = $verbinding->prepare($update_sql);

    if ($query->execute([$status, $order_id])) {
        echo "<script>alert('Status bijgewerkt!');</script>";
    } else {
        echo "<script>alert('Fout bij het bijwerken van de status.');</script>";
    }
}

$rows = toonBestellingen($verbinding);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = intval($_POST['order_id']);
    $status = intval($_POST['status']);
    updateOrderStatus($verbinding, $order_id, $status);
    header("Location: bestellingoverzicht.php");
    exit();
}

$isIngelogd = isGebruikerIngelogd();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellingoverzicht Personeel</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div id="login-status">
            <?php toonLoginStatus($isIngelogd); ?>
        </div>
    </header>
    <h1>Bestellingoverzicht Personeel</h1>
    <ul id="order-list">
        <?php if (count($rows) > 0): ?>
            <?php 
            $current_order_id = null;
            foreach ($rows as $row): 
                if ($current_order_id !== $row['order_id']):
                    if ($current_order_id !== null):
            ?>
                        </ul></li>
            <?php endif; ?>
                    <li>
                        <p>
                            <a href="detailoverzicht.php?order_id=<?= htmlspecialchars($row['order_id']) ?>">Bestelling #<?= htmlspecialchars($row['order_id']) ?></a>
                        </p>
                        <p>Klant: <?= htmlspecialchars($row['client_name']) ?></p>
                        
                        <?php if ($row['status'] != 3) : ?>
                            <form method="post" action="bestellingoverzicht.php">
                                <input type="hidden" name="order_id" value="<?= htmlspecialchars($row['order_id']) ?>">
                                <label for="status-<?= $row['order_id'] ?>">Wijzig status:</label>
                                <select id="status-<?= $row['order_id'] ?>" name="status">
                                    <option value="1" <?= $row['status'] == 1 ? 'selected' : '' ?>>Aan het bereiden</option>
                                    <option value="2" <?= $row['status'] == 2 ? 'selected' : '' ?>>Onderweg</option>
                                    <option value="3" <?= $row['status'] == 3 ? 'selected' : '' ?>>Afgeleverd</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        <?php else: ?>
                            <p>Status: <strong>Afgeleverd</strong> (Kan niet worden gewijzigd)</p>
                        <?php endif; ?>
                        
                        <ul>
            <?php 
                    $current_order_id = $row['order_id'];

            endif; endforeach; ?>
            </ul></li>
        <?php else: ?>
            <p>Geen bestellingen gevonden.</p>
        <?php endif; ?>
    </ul>
</body>
</html>
