<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelling Bevestigen</title>
    <link rel="stylesheet" href="../Style/Style.css">
</head>

<body>
    <header>
        <h1 class="h1-header">Bevestig uw bestelling</h1>
        <p>Bevestig uw bestelling en dan zijn wij zo snel mogelijk bij u!</p>
    </header>

    <nav>
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </label>
        <ul class="navbar" id="nav-links">
            <li><a href="KlantenHome.php">Home</a></li>
            <li><a href="KlantenMenu.php">Menu</a></li>
            <li><a href="KlantenWinkelmandje.php">Winkelmand</a></li>
            <li><a href="KlantenMijnBestellingen.php">Mijn Bestellingen</a></li>
            <li><a href="../Gebruikers/Index.php">Loguit</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Bevestig uw Bestelling</h1>
        <div class="customer-info">
            <h2>Uw Gegevens</h2>
            <form action="KlantenMijnBestellingen.php" method="post">
                <strong>Naam:</strong>
                <p>NaamKlant</p>
                <strong>Straatnaam</strong>
                <p>StraatNaam</p>
                <strong>Stadnaam</strong>
                <p>StadNaam</p>
                <strong>Postcode</strong>
                <p>1111AA</p>
                <div class="order-summary">
                    <h2>Uw Bestelling</h2>
                    <ul class="order-list">
                        <li>Product 1 - €20.00</li>
                        <li>Product 2 - €15.00</li>
                        <li>Product 3 - €30.00</li>
                    </ul>
                    <div class="total">
                        <strong>Totaal: €65.00</strong>
                    </div>
                </div>
                <button type="submit" class="confirm-btn">Bevestig bestelling</button>
            </form>
        </div>
    </div>

    <?php require_once '../footer.php'; ?>
    
</body>

</html>