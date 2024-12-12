<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratie Pagina</title>
    <link rel="stylesheet" href="../Style/Style.css">
</head>

<body>
    <header>
        <h1 class="h1-header">Registreer</h1>
        <p>Registreer je hier om uw ervaring nog persoonlijker te maken!</p>
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
    <div class="login-container">
        <h2>Registreer</h2>
        <form action="Login.php" method="post">
            <div class="input-group">
                <label for="firstname">Voornaam:</label>
                <input type="text" id="firstname" name="firstname" pattern="[a-zA-Z\s]+" required>
            </div>
            <div class="input-group">
                <label for="lastname">Achternaam:</label>
                <input type="text" id="lastname" name="lastname" pattern="[a-zA-Z\s]+" required>
            </div>
            <div class="input-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="address">Straatnaam:</label>
                <input type="text" id="address" name="address" pattern="[a-zA-Z\s]+" required>
            </div>
            <div class="input-group">
                <label for="city">Stad:</label>
                <input type="text" id="city" name="city" pattern="[a-zA-Z\s]+" required>
            </div>
            <div class="input-group">
                <label for="postal-code">Postcode:</label>
                <input type="text" id="postal-code" name="postal-code" pattern="^[0-9]{4}[A-Z]{2}$"
                    title="Voer een geldige postcode in (bijv. 1234AB)" required>
            </div>
            <div class="input-group">
                <label for="username">Gebruikersnaam:</label>
                <small>Minimaal 8 karakters</small>
                <input type="text" id="username" name="username" pattern="[a-zA-Z0-9]{8,}" required>
            </div>
            <div class="input-group">
                <label for="password">Wachtwoord:</label>
                <small>Tussen 8 en 16 karakters</small>
                <input type="password" id="password" name="password" pattern="[a-zA-Z0-9]{8,16}" required>
            </div>
            <div class="input-group">
                <label for="confirm-password">Bevestig Wachtwoord:</label>
                <small>Tussen 8 en 16 karakters</small>
                <input type="password" id="confirm-password" name="confirm-password" pattern="[a-zA-Z0-9]{8,16}"
                    required>
            </div>
            <button type="submit" class="login-btn">Registreren</button>
        </form>
        <p>Al een account? <a class="link-style-login" href="Login.php">Log hier in</a></p>
    </div>

    <?php require_once '../footer.php'; ?>

</body>

</html>