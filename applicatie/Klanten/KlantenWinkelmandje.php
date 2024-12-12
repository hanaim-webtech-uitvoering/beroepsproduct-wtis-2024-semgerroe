<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelmandje</title>
    <link rel="stylesheet" href="../Style/Style.css">
</head>

<body>

    <header>
        <h1 class="h1-header">Winkelmandje</h1>
        <p>Bekijk je winkelmandje en pas de hoeveelheden aan.</p>
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
            <li><a href="#">Winkelmand</a></li>
            <li><a href="KlantenMijnBestellingen.php">Mijn Bestellingen</a></li>
            <li><a href="../Gebruikers/Index.php">Loguit</a></li>
        </ul>
    </nav>
    <form action="KlantenBestellingAfronden.php" method="post">
        <section class="purchase-list">
            <div class="purchase-header">
                <h2>Productnaam</h2>
                <h2>Prijs</h2>
                <h2>Hoeveelheid</h2>
                <h2>Totaal</h2>
            </div>
            <div class="purchase-item">
                <span>Product A</span>
                <span>€10,00</span>
                <span>
                    <input type="number" class="quantity-input" name="quantityA" value="1" min="1">
                </span>
                <span>€10,00</span>
            </div>
            <div class="purchase-item">
                <span>Product B</span>
                <span>€15,00</span>
                <span>
                    <input type="number" class="quantity-input" name="quantityB" value="1" min="1">
                </span>
                <span>€15,00</span>
            </div>
            <div class="purchase-summary">
                <span><strong>Totaal:</strong></span>
                <span>€25,00</span>
            </div>
            <button type="submit" class="complete-purchase-btn">Bestelling Afronden</button>
        </section>
    </form>

    <?php require_once '../footer.php'; ?>

</body>

</html>