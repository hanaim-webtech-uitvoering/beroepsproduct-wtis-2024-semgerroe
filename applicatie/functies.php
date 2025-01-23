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


?>
