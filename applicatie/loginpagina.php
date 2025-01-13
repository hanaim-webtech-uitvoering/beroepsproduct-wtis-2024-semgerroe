<?php
// Start de sessie
session_start();

// Include de databaseverbinding
require_once('db_connectie.php');

// Controleer of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verkrijg de ingevoerde gegevens
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Maak de databaseverbinding
    $db = maakVerbinding();

    // Query om de gebruiker op te halen op basis van gebruikersnaam en rol
    $sql = "SELECT * FROM [User] WHERE username = :username AND [role] = :role";
    $query = $db->prepare($sql);
    $query->bindParam(':username', $username);
    $query->bindParam(':role', $role);
    $query->execute();

    // Verkrijg het resultaat
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Controleer of de gebruiker bestaat en het wachtwoord klopt
    if ($user && password_verify($password, $user['password'])) {
        // Sla de gebruikersinformatie op in de sessie
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect naar de juiste pagina op basis van de rol
        if ($user['role'] === 'Client') {
            header("Location: menupagina.php");
        } elseif ($user['role'] === 'Personnel') {
            header("Location: detailOverzicht.php");
        }
        exit;
    } else {
        // Foutmelding als de inloggegevens onjuist zijn
        $error_message = "Onjuiste gebruikersnaam of wachtwoord.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Login</h1>
    
    <!-- Foutmelding weergeven als de inloggegevens onjuist zijn -->
    <?php if (isset($error_message)) { echo "<p style='color: red;'>$error_message</p>"; } ?>

    <form method="post" action="loginpagina.php">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Wachtwoord:</label>
        <input type="password" id="password" name="password" required>

        <label for="role">Login als:</label>
        <select id="role" name="role" required>
            <option value="klant">Klant</option>
            <option value="personeel">Personeel</option>
        </select>

        <button type="submit">Login</button>
    </form>

    <p>Heb je nog geen account? <a href="registratiepagina.php">Registreer hier</a>.</p>
</body>
</html>
