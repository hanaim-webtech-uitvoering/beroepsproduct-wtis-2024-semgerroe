<?php
require_once('db_connectie.php');

function isGebruikerIngelogd() {
    return isset($_SESSION['username']) && isset($_SESSION['role']);
}

function toonLoginStatus() {
    if (isGebruikerIngelogd()) {
        echo "<p>Ingelogd als: <strong>" . $_SESSION['username'] . "</strong></p>";
        echo "<p>Je rol: <strong>" . $_SESSION['role'] . "</strong></p>";
        echo "<p><a href='../loguit.php'>Loguit</a></p>";
    } else {
        echo "<p>Je bent niet ingelogd. <a href='../loginpagina.php'>Log in</a></p>";
    }
}

function haalProductInfoOp($productName) {
    $db = maakVerbinding();
    $sql = "SELECT price, name FROM Product WHERE name = :product_name";
    $query = $db->prepare($sql);
    $query->execute(['product_name' => $productName]);
    return $query->fetch(PDO::FETCH_ASSOC);
}

function toonFoutmeldingen($error_messages) {
    if (!empty($error_messages)) {
        echo "<ul style='color: red;'>";
        foreach ($error_messages as $message) {
            echo "<li>$message</li>";
        }
        echo "</ul>";
}
}



?>
