<!-- Profiel Page (KL-04) -->
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiel</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Profiel</h1>

    <h2>Vorige Bestellingen</h2>
    <ul id="previous-orders">
        <!-- Dynamische vorige bestellingen worden hier geladen -->
        <li>
            <p>Bestelling #1236</p>
            <p>Status: <span>Afgeleverd</span></p>
            <!-- Geen annuleerknop omdat de bestelling al is afgeleverd -->
        </li>
    </ul>

    <h2>Huidige Bestellingen</h2>
    <ul id="current-orders">
        <!-- Dynamische huidige bestellingen worden hier geladen -->
        <li>
            <p>Bestelling #1234</p>
            <p>Status: <span>Aan het bereiden</span></p>
            <form method="post" action="annuleer_bestelling.php">
                <input type="hidden" name="order_id" value="1234">
                <button type="submit">Annuleer Bestelling</button>
            </form>
        </li>
        <li>
            <p>Bestelling #1235</p>
            <p>Status: <span>Onderweg</span></p>
            <form method="post" action="annuleer_bestelling.php">
                <input type="hidden" name="order_id" value="1235">
                <button type="submit">Annuleer Bestelling</button>
            </form>
        </li>
    </ul>
</body>
</html>
