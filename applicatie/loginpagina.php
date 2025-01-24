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

    $user = haalGebruikersDetailsOp($db, $username);

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


function haalGebruikersDetailsOp($db, $username) {
    $sql = "SELECT * FROM [User] WHERE username = :username";
    $query = $db->prepare($sql);
    $query->execute([':username' => $username]);
    return $query->fetch(PDO::FETCH_ASSOC);
}


function startSessie($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
}

function redirectOpBasisVanRol($role) {
    if ($role === 'Client') {
        header("Location: Klanten/menupagina.php");
    } elseif ($role === 'Personnel') {
        header("Location: Personeelsleden/bestellingOverzicht.php");
    }
    exit;
}

function toonLoginFormulier($username = '', $role = '') {
    ?>
    <form method="post" action="loginpagina.php">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>" required>

        <label for="password">Wachtwoord:</label>
        <input type="password" id="password" name="password" required>

        <label for="role">Login als:</label>
        <select id="role" name="role" required>
            <option value="Client" <?= ($role === 'Client') ? 'selected' : '' ?>>Klant</option>
            <option value="Personnel" <?= ($role === 'Personnel') ? 'selected' : '' ?>>Personeel</option>
        </select>

        <button type="submit">Login</button>
    </form>
    <?php
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

    <?php toonFoutmeldingen($error_messages); ?>

    <?php toonLoginFormulier($_POST['username'] ?? '', $_POST['role'] ?? ''); ?>


    <p>Heb je nog geen account? <a href="registratiepagina.php">Registreer hier</a>.</p>
</body>
</html>

