<?php
// Include de databaseverbinding
require_once('../db_connectie.php');

// Haal producten op uit de database
$db = maakVerbinding();
$sql = "SELECT name, price, type_id
        FROM Product";
$query = $db->prepare($sql);
$query->execute();

$producten = $query->fetchAll(PDO::FETCH_ASSOC);
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
    <h1>Menu</h1>
    <ul id="menu-items">
        <?php
        if ($producten) {
            foreach ($producten as $product) {
                echo "<li>";
                echo "<h2>" . htmlspecialchars($product['name']) . "</h2>";
                echo "<p>Prijs: €" . number_format($product['price'], 2, ',', '.') . "</p>";
                echo "<p>Type: " . htmlspecialchars($product['type_id']) . "</p>";
                echo "<button>Toevoegen</button>";
                echo "</li>";
            }
        } else {
            echo "<li>Geen producten beschikbaar</li>";
        }
        ?>
    </ul>
</body>
</html>
