<?php
// Verbindungsinformationen für die Datenbank
$servername = "localhost";
$username = "root"; // Standardnutzername für MAMP
$password = "root"; // Standardpasswort für MAMP (prüfe die MAMP-Einstellungen)
$dbname = "user_registration";

// Verbindung zur MySQL-Datenbank herstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung überprüfen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Formular-Eingaben sichern
$email = $conn->real_escape_string($_POST['email']);
$first_name = $conn->real_escape_string($_POST['first_name']);
$last_name = $conn->real_escape_string($_POST['last_name']);
$password = $conn->real_escape_string($_POST['password']);

// Passwort-Hash erzeugen
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Überprüfen, ob die E-Mail bereits registriert ist
$sql = "SELECT id FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Benutzer existiert bereits
    header("Location: index.php?message=Diese E-Mail ist bereits registriert.");
    exit();
} else {
    // Neuen Benutzer einfügen
    $sql = "INSERT INTO users (email, first_name, last_name, password) VALUES ('$email', '$first_name', '$last_name', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        // Erfolgreich registriert
        header("Location: index.php?message=Registrierung erfolgreich!");
        exit();
    } else {
        // Fehler bei der Registrierung
        header("Location: index.php?message=Fehler bei der Registrierung: " . $conn->error);
        exit();
    }
}

// Verbindung schließen
$conn->close();
?>
