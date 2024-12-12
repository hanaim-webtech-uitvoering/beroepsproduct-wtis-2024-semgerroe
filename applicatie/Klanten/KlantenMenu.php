<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/Style.css">
    <title>Menukaart - Pizzeria Sole Machina</title>
</head>

<body>
    <header>
        <h1 class="h1-header">Menukaart - Pizzeria Sole Machina</h1>
        <p>Kies uit onze heerlijke pizza's en plaats direct een bestelling!</p>
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
            <li><a href="#">Menu</a></li>
            <li><a href="KlantenWinkelmandje.php">Winkelmand</a></li>
            <li><a href="KlantenMijnBestellingen.php">Mijn Bestellingen</a></li>
            <li><a href="../Gebruikers/Index.php">Loguit</a></li>
        </ul>
    </nav>

    <main>
        <section class="menu">
            <h2>Pizza's</h2>
            <div class="menu-item">
                <h3>Margherita</h3>
                <p>Een klassieke pizza met tomatensaus, mozzarella en verse basilicum.</p>
                <p class="price">€9,50</p>
                <form action="KlantenWinkelmandje.php" method="get">
                    <button class="order-btn">Bestel nu</button>
                </form>
            </div>

            <div class="menu-item">
                <h3>Quattro Stagioni</h3>
                <p>Een heerlijke pizza met ham, champignons, artisjokken en olijven.</p>
                <p class="price">€12,00</p>
                <form action="KlantenWinkelmandje.php" method="get">
                    <button class="order-btn">Bestel nu</button>
                </form>
            </div>

            <div class="menu-item">
                <h3>Diavola</h3>
                <p>Pittige pizza met tomatensaus, mozzarella, pikante salami en chili.</p>
                <p class="price">€11,50</p>
                <form action="KlantenWinkelmandje.php" method="get">
                    <button class="order-btn">Bestel nu</button>
                </form>
            </div>

            <div class="menu-item">
                <h3>Vegetariana</h3>
                <p>Pizza met gegrilde groenten, tomatensaus en mozzarella.</p>
                <p class="price">€10,50</p>
                <form action="KlantenWinkelmandje.php" method="get">
                    <button class="order-btn">Bestel nu</button>
                </form>
            </div>
        </section>
    </main>

    <?php require_once '../footer.php'; ?>

</body>

</html>