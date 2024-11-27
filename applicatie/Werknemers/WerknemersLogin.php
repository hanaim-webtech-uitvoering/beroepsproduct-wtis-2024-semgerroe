<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pagina</title>
    <link rel="stylesheet" href="../Style/Style.css">
</head>

<body>
    <header>
        <h1 class="h1-header">Login</h1>
        <p>Log hier in om uw ervaring nog persoonlijker te maken!</p>
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
            <li><a href="../Gebruikers/Login.php">Login</a></li>
        </ul>
    </nav>
    <div class="login-container">
        <h2>Login</h2>
        <form action="WerknemersHome.php" method="post">
            <div class="input-group">
                <label for="username">Gebruikersnaam:</label>
                <small>Minimaal 8 karakters</small>
                <input type="text" id="username" name="username" pattern="[a-zA-Z0-9]{8,}" required>
            </div>
            <div class="input-group">
                <label for="password">Wachtwoord:</label>
                <small>8 - 16 karakters</small>
                <input type="password" id="password" name="password" pattern="[a-zA-Z0-9]{8,16}" required>
            </div>
            <button type="submit" class="login-btn">Inloggen</button>
        </form>
        <p>Nog geen account? Registreer <a class="link-style-login" href="registratie.php">hier</a></p>
        <p>Klant? Log dan <a class="link-style-login" href="../Werknemers/WerknemersLogin.php">hier</a> in.</p>
    </div>
    <footer>
        <div class="footer-content">
            <a class="link-style" href="../Gebruikers/PrivacyVerklaring.php">&copy; 2024 Pizzeria Sole Machina. Alle
                rechten voorbehouden.</a>
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