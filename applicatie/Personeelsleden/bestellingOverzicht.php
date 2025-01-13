<!-- Bestellingoverzicht Personeel Page (PE-02, PE-03) -->
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellingoverzicht Personeel</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Bestellingoverzicht Personeel</h1>
    <ul id="active-orders">
        <!-- Dynamische actieve bestellingen worden hier geladen -->
        <li>
            <p>Bestelling #1234</p>
            <p>Status: <span>Aan het bereiden</span></p>
            <form method="post" action="update_status.php">
                <input type="hidden" name="order_id" value="1234">
                <label for="status-1234">Wijzig status:</label>
                <select id="status-1234" name="status">
                    <option value="Aan het bereiden">Aan het bereiden</option>
                    <option value="Onderweg">Onderweg</option>
                    <option value="Afgeleverd">Afgeleverd</option>
                </select>
                <button type="submit">Update</button>
            </form>
        </li>
        <li>
            <p>Bestelling #1235</p>
            <p>Status: <span>Onderweg</span></p>
            <form method="post" action="update_status.php">
                <input type="hidden" name="order_id" value="1235">
                <label for="status-1235">Wijzig status:</label>
                <select id="status-1235" name="status">
                    <option value="Aan het bereiden">Aan het bereiden</option>
                    <option value="Onderweg">Onderweg</option>
                    <option value="Afgeleverd">Afgeleverd</option>
                </select>
                <button type="submit">Update</button>
            </form>
        </li>
    </ul>
</body>
</html>