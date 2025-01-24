<?php 

$isIngelogd = isGebruikerIngelogd();

 ?>

<header>
    <div id="login-status">
        <?php toonLoginStatus($isIngelogd); ?>
    </div>
    <div id="header-icons">
        <div id="shopping-cart">
            <a href="winkelmandje.php">
                <img src="../images/cart.png" alt="Winkelmand" />
                <span id="cart-count">
                    <?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>
                </span>
            </a>
        </div>

        <div id="header-icons">
            <a href="menupagina.php">
                <img src="../images/home.png" alt="Menupagina" />
        </div>
        
        <?php if ($isIngelogd): ?>
        <div id="profile">
            <a href="profielpagina.php">
                <img src="../images/profile-icon.png" alt="Profiel" />
            </a>
        </div>
        <?php endif; ?>
    </div>
</header>
