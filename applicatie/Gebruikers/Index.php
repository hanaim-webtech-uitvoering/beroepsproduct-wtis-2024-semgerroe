<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/Style.css">
    <title>Pizzeria Sole Machina Index</title>
</head>

<body>
    <header>
        <h1 class="h1-header">Pizzeria Sole Machina</h1>
        <p class="toast replace">De beste authentieke pizza's in de stad!</p>
    </header>

    <nav>
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </label>
        <ul class="navbar" id="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="Menu.php">Menu</a></li>
            <li><a href="Winkelmandje.php">Winkelmand</a></li>
            <li><a href="MijnBestellingen.php">Mijn Bestellingen</a></li>
            <li><a href="Login.php">Login</a></li>
        </ul>
    </nav>

    <section id="about">
        <h2>Welkom bij Pizzeria Sole Machina</h2>
        <p>Bij ons proef je de smaak van Italië in elke hap! Onze meester-pizzabakkers gebruiken enkel de beste
            ingrediënten om de meest heerlijke en knapperige pizza's te bereiden. Of je nu houdt van een klassieke
            Margherita of een speciale Quattro Stagioni, bij ons ben je aan het juiste adres.</p>
        <a href="Menu.php" class="menu-btn">Bekijk ons menu</a>
    </section>

    <section id="hours">
        <h2>Openingstijden</h2>
        <ul>
            <li>Maandag - Vrijdag: 12:00 - 22:00</li>
            <li>Zaterdag: 14:00 - 23:00</li>
            <li>Zondag: 14:00 - 21:00</li>
        </ul>
    </section>

    <?php require_once '../footer.php'; ?>

</body>

</html>