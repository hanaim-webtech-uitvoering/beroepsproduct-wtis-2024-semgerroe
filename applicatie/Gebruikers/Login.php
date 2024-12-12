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
            <li><a href="#">Login</a></li>
        </ul>
    </nav>
    <div class="login-container">
        <h2>Login</h2>
        <form action="../Klanten/KlantenHome.php" method="post">
            <div class="input-group">
                <label for="text">Gebruikersnaam:</label>
                <small>Minimaal 8 karakters</small>
                <input type="text" id="text" name="text" pattern="[a-zA-Z0-9]{8,}" required>
            </div>
            <div class="input-group">
                <label for="password">Wachtwoord:</label>
                <small>8 - 16 karakters</small>
                <input type="password" id="password" name="password" pattern="[a-zA-Z0-9]{8,16}" required>
            </div>
            <button type="submit" class="login-btn">Inloggen</button>
        </form>
        <p>Nog geen account? Registreer <a class="link-style-login" href="registratie.php">hier</a></p>
        <p>Medewerker? Log dan <a class="link-style-login" href="../Werknemers/WerknemersLogin.php">hier</a> in.</p>
    </div>

    <?php require_once '../footer.php'; ?>
    
</body>

</html>