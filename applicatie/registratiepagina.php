<?php
session_start();

require_once('db_connectie.php');

$error_messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $role = $_POST['role'];

    $error_messages = valideerInvoer($username, $password, $first_name, $last_name, $role);

    if (empty($error_messages)) {
        $db = maakVerbinding();

        if (controleerGebruikersnaam($db, $username)) {
            $error_messages[] = "De gebruikersnaam is al in gebruik.";
        } else {
            if (voegGebruikerToe($db, $username, $password, $first_name, $last_name, $role)) {
                header("Location: loginpagina.php");
                exit;
            } else {
                $error_messages[] = "Er is een fout opgetreden bij de registratie.";
            }
        }
    }
}

function valideerInvoer($username, $password, $first_name, $last_name, $role) {
    $errors = [];

    if (empty($username) || empty($password) || empty($first_name) || empty($last_name) || empty($role)) {
        $errors[] = "Alle velden moeten worden ingevuld.";
    }

    if (!empty($username) && strlen($username) < 2) {
        $errors[] = "De gebruikersnaam moet minstens 2 tekens lang zijn.";
    }

    if (!empty($password)) {
        if (strlen($password) < 8) {
            $errors[] = "Het wachtwoord moet minstens 8 tekens lang zijn.";
    }
}
    return $errors;
}


function controleerGebruikersnaam($db, $username) {
    $sql = "SELECT * FROM [User] WHERE username = :username";
    $query = $db->prepare($sql);
    $query->execute([':username' => $username]);

    return $query->rowCount() > 0;
}

function voegGebruikerToe($db, $username, $password, $first_name, $last_name, $role) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO [User] (username, [password], first_name, last_name, [role]) 
            VALUES (:username, :password, :first_name, :last_name, :role)";
    $query = $db->prepare($sql);

    return $query->execute([
        ':username' => $username,
        ':password' => $hashed_password,
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':role' => $role
    ]);
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratie</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Registratie</h1>
    
    <!-- Foutmeldingen weergeven -->
    <?php 
    if (!empty($error_messages)) {
        echo "<ul style='color: red;'>";
        foreach ($error_messages as $message) {
            echo "<li>$message</li>";
        }
        echo "</ul>";
    }
    ?>

<form method="post" action="registratiepagina.php">
    <label for="first_name">Voornaam:</label>
    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name ?? ''); ?>" required>

    <label for="last_name">Achternaam:</label>
    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name ?? ''); ?>" required>

    <label for="username">Gebruikersnaam:</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>

    <label for="password">Wachtwoord:</label>
    <input type="password" id="password" name="password" required>

    <label for="role">Rol:</label>
    <select id="role" name="role" required>
        <option value="Client" <?php echo (isset($role) && $role === 'Client') ? 'selected' : ''; ?>>Klant</option>
        <option value="Personnel" <?php echo (isset($role) && $role === 'Personnel') ? 'selected' : ''; ?>>Personeel</option>
    </select>

    <button type="submit">Registreren</button>
</form>


    <p>Heb je al een account? <a href="loginpagina.php">Login hier</a>.</p>
</body>
</html>
