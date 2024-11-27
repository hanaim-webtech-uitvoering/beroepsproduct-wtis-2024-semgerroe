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
            <li><a href="Index.php">Home</a></li>
            <li><a href="Menu.php">Menu</a></li>
            <li><a href="Winkelmandje.php">Winkelmand</a></li>
            <li><a href="MijnBestellingen.php">Mijn Bestellingen</a></li>
            <li><a href="Login.php">Login</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Bevestig uw Bestelling</h1>
        <div class="customer-info">
            <h2>Uw Gegevens</h2>
            <form action="MijnBestellingen.php" method="post">
                <label for="name">Naam:</label>
                <input type="text" id="name" name="name" pattern="[a-zA-Z\s]+" required>
                <label for="address">Straatnaam:</label>
                <input type="text" id="address" name="address" pattern="[a-zA-Z\s]+" required>
                <label for="city">Stad:</label>
                <input type="text" id="city" name="city" pattern="[a-zA-Z\s]+" required>
                <label for="postal-code">Postcode:</label>
                <input type="text" id="postal-code" name="postal-code" pattern="^[0-9]{4}[A-Z]{2}$"
                    title="Voer een geldige postcode in (bijv. 1234AB)" required>
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
    <footer>
        <div class="footer-content">
            <a class="link-style" href="PrivacyVerklaring.php">&copy; 2024 Pizzeria Sole Machina. Alle rechten voorbehouden.</a>
            <div class="divider"></div>
            <section id="contact">
                <h2>Contact</h2>
                <p><strong>Adres:</strong> Via Italia 24, 1234 AB, Pizza City</p>
                <p><strong>Telefoon:</strong> +31 123 456 789</p>
                <p><strong>Email:</strong> info@solemachina.nl</p>
            </section>
        </div>
    </footer>
</body>

</html>