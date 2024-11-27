<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Bestellingen</title>
    <link rel="stylesheet" href="../Style/Style.css">
</head>

<body>

    <header>
        <h1 class="h1-header">Jouw Bestellingen</h1>
        <p>Hier kun je alle informatie over je geplaatste bestellingen vinden.</p>
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
            <li><a href="#">Mijn Bestellingen</a></li>
            <li><a href="Login.php">Login</a></li>
        </ul>
    </nav>
        <section class="order-list">
            <div class="order-header">
                <h2>Order ID</h2>
                <h2>Productnaam</h2>
                <h2>Datum en Tijd</h2>
                <h2>Status</h2>
                <h2>Leveradres</h2>
            </div>
            <div class="order-item">
                <span>#12345</span>
                <span>Product A</span>
                <span>11-11-2024 14:32</span>
                <span>In Behandeling</span>
                <span>Straat 123, Stad</span>
            </div>
            <div class="order-item">
                <span>#12346</span>
                <span>Product B</span>
                <span>11-11-2024 15:00</span>
                <span>Verzonden</span>
                <span>Straat 456, Stad</span>
            </div>
        </section>

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