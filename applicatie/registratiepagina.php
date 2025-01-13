<?php
// Start de sessie
session_start();

// Include de databaseverbinding
require_once('db_connectie.php');

// Variabele voor foutmeldingen
$error_message = '';

// Verwerk formulier als het is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verkrijg de ingevoerde gegevens
    $username = $_POST['username'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $role = $_POST['role'];

    // Validatie van de invoer
    if (empty($username) || empty($password) || empty($first_name) || empty($last_name) || empty($role)) {
        $error_message = "Alle velden moeten worden ingevuld.";
    } else {
        // Maak de databaseverbinding
        $db = maakVerbinding();

        // Controleer of de gebruikersnaam al bestaat
        $sql_check = "SELECT * FROM [User] WHERE username = :username";
        $query_check = $db->prepare($sql_check);
        $query_check->bindParam(':username', $username);
        $query_check->execute();

        if ($query_check->rowCount() > 0) {
            $error_message = "De gebruikersnaam is al in gebruik.";
        } else {
            // Hash het wachtwoord voor veilige opslag
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Query om de nieuwe gebruiker toe te voegen
            $sql = "INSERT INTO [User] (username, [password], first_name, last_name, [role]) 
                    VALUES (:username, :password, :first_name, :last_name, :role)";
            $query = $db->prepare($sql);
            $query->bindParam(':username', $username);
            $query->bindParam(':password', $hashed_password);
            $query->bindParam(':first_name', $first_name);
            $query->bindParam(':last_name', $last_name);
            $query->bindParam(':role', $role);

            // Voer de query uit
            if ($query->execute()) {
                // Redirect naar loginpagina na succesvolle registratie
                header("Location: loginpagina.php");
                exit;
            } else {
                $error_message = "Er is een fout opgetreden bij de registratie.";
            }
        }
    }
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
    
    <!-- Foutmelding weergeven -->
    <?php if ($error_message) { echo "<p style='color: red;'>$error_message</p>"; } ?>

    <form method="post" action="registratiepagina.php">
        <label for="first_name">Voornaam:</label>
        <input type="text" id="first_name" name="first_name" required>

        <label for="last_name">Achternaam:</label>
        <input type="text" id="last_name" name="last_name" required>

        <label for="username">Gebruikersnaam:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Wachtwoord:</label>
        <input type="password" id="password" name="password" required>

        <label for="role">Rol:</label>
        <select id="role" name="role" required>
            <option value="klant">Klant</option>
            <option value="personeel">Personeel</option>
        </select>

        <button type="submit">Registreren</button>
    </form>

    <p>Heb je al een account? <a href="loginpagina.php">Login hier</a>.</p>
</body>
</html>
