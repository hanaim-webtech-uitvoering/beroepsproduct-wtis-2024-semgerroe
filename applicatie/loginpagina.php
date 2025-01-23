<?php
session_start();

require_once('db_connectie.php');
require_once('functies.php');

$error_messages = [];

if (isGebruikerIngelogd()) {
    redirectOpBasisVanRol($_SESSION['role']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $db = maakVerbinding();

    // Haal gebruiker op basis van gebruikersnaam
    $user = haalGebruikerOpDoorGebruikersnaam($db, $username);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            if ($user['role'] === $role) {
                startSessie($user);
                redirectOpBasisVanRol($user['role']);
            } else {
                $error_messages[] = "Verkeerde rol is geselecteerd.";
            }
        } else {
            $error_messages[] = "Het wachtwoord is onjuist.";
        }
    } else {
        $error_messages[] = "De gebruikersnaam bestaat niet.";
    }
}

/**
 * Haalt een gebruiker op basis van gebruikersnaam.
 */
function haalGebruikerOpDoorGebruikersnaam($db, $username) {
    $sql = "SELECT * FROM [User] WHERE username = :username";
    $query = $db->prepare($sql);
    $query->execute([':username' => $username]);
    return $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Start een sessie met de gebruikersgegevens.
 */
function startSessie($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
}

/**
 * Redirect de gebruiker op basis van hun rol.
 */
function redirectOpBasisVanRol($role) {
    if ($role === 'Client') {
        header("Location: Klanten/menupagina.php");
    } elseif ($role === 'Personnel') {
        header("Location: Personeelsleden/bestellingOverzicht.php");
    }
    exit;
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

    <!-- Foutmeldingen weergeven -->
    <?php if (!empty($error_messages)): ?>
        <ul style="color: red;">
            <?php foreach ($error_messages as $message): ?>
                <li><?= htmlspecialchars($message) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="loginpagina.php">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>

        <label for="password">Wachtwoord:</label>
        <input type="password" id="password" name="password" required>

        <label for="role">Login als:</label>
        <select id="role" name="role" required>
            <option value="Client" <?= (isset($_POST['role']) && $_POST['role'] === 'Client') ? 'selected' : '' ?>>Klant</option>
            <option value="Personnel" <?= (isset($_POST['role']) && $_POST['role'] === 'Personnel') ? 'selected' : '' ?>>Personeel</option>
        </select>

        <button type="submit">Login</button>
    </form>

    <p>Heb je nog geen account? <a href="registratiepagina.php">Registreer hier</a>.</p>
</body>
</html>

