<?php
session_start();

require_once('db_connectie.php');
require_once('functies.php');

$error_messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $role = $_POST['role'];
    $address = $_POST['address'];

    $error_messages = valideerInvoer($username, $password, $first_name, $last_name, $role, $address);

    if (empty($error_messages)) {
        $db = maakVerbinding();

        if (checkBestaatGebruikersnaam($db, $username)) {
            $error_messages[] = "De gebruikersnaam is al in gebruik.";
        } else {
            if (voegGebruikerToe($db, $username, $password, $first_name, $last_name, $role, $address)) {
                header("Location: loginpagina.php");
                exit;
            } else {
                $error_messages[] = "Er is een fout opgetreden bij de registratie.";
            }
        }
    }
}

function valideerInvoer($username, $password, $first_name, $last_name, $role, $address) {
    $errors = [];

    if (empty($username) || empty($password) || empty($first_name) || empty($last_name) || empty($role) || empty($address)) {
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

    if (!preg_match("/^[a-zA-Z\s]+ \d{1,4}, \d{4}\s?[A-Za-z]{2}, [a-zA-Z\s]+$/", $address)) {
        $errors[] = "Vul een geldig adres in (bijv. straat 123, 1234 AB, Amsterdam).";
    }

    return $errors;
}
function checkBestaatGebruikersnaam($db, $username) {
    $sql = "SELECT * FROM [User] WHERE username = :username";
    $query = $db->prepare($sql);
    $query->execute([':username' => $username]);

    return $query->rowCount() > 0;
}

function voegGebruikerToe($db, $username, $password, $first_name, $last_name, $role, $address) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO [User] (username, [password], first_name, last_name, [role], address) 
            VALUES (:username, :password, :first_name, :last_name, :role, :address)";
    $query = $db->prepare($sql);

    return $query->execute([
        ':username' => $username,
        ':password' => $hashed_password,
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':role' => $role,
        ':address' => $address
    ]);
}


function toonRegistratieFormulier($first_name = '', $last_name = '', $username = '', $role = '') {
    ?>
<form method="post" action="registratiepagina.php">
    <label for="first_name">Voornaam:</label>
    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required>

    <label for="last_name">Achternaam:</label>
    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required>

    <label for="username">Gebruikersnaam:</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>

    <label for="password">Wachtwoord:</label>
    <input type="password" id="password" name="password" required>

    <label for="address">Adres:</label>
    <input type="text" id="address" name="address" placeholder="straat 123, 1234 AB, Amsterdam"
           pattern="^[a-zA-Z\s]+ \d{1,4}, \d{4}\s?[A-Za-z]{2}, [a-zA-Z\s]+$" 
           title="Vul een geldig adres in (bijv. straat 123, 1234 AB, Amsterdam)">

    <label for="role">Rol:</label>
    <select id="role" name="role" required>
        <option value="Client" <?php echo ($role === 'Client') ? 'selected' : ''; ?>>Klant</option>
        <option value="Personnel" <?php echo ($role === 'Personnel') ? 'selected' : ''; ?>>Personeel</option>
    </select>

    <button type="submit">Registreren</button>
</form>
    <?php
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

    <?php toonFoutmeldingen($error_messages); ?>

    <?php toonRegistratieFormulier($_POST['first_name'] ?? '', $_POST['last_name'] ?? '', $_POST['username'] ?? '', $_POST['role'] ?? ''); ?>

    <p>Heb je al een account? <a href="loginpagina.php">Login hier</a>.</p>
</body>
</html>

