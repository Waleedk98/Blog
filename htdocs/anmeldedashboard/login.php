<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anmelden</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            width: 400px;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }
        .container h2 {
            color: #1877f2;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        input[type="submit"] {
            background-color: #1877f2;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 20px;
        }
        .message {
            margin-top: 15px;
            color: red;
        }
        .register-link {
            margin-top: 20px;
        }
        .register-link a {
            color: #1877f2;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Anmelden</h2>
        <form action="login.php" method="post">
            <input type="text" name="email" placeholder="E-Mail" required>
            <input type="password" name="password" placeholder="Passwort" required>
            <input type="submit" value="Anmelden">
        </form>

        <?php
        if (isset($_GET['message'])) {
            echo '<p class="message">' . htmlspecialchars($_GET['message']) . '</p>';
        }
        ?>

        <!-- Link zur Registrierungsseite -->
        <div class="register-link">
            <p>Noch kein Konto? <a href="index.php">Hier registrieren</a></p>
        </div>
    </div>

</body>
</html>

<?php
// login.php - Verarbeitet die Anmeldung
session_start();
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "user_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Suche nach dem Benutzer
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Überprüfe das Passwort
        if (password_verify($password, $user['password'])) {
            // Anmeldung erfolgreich
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            header("Location: dashboard.php");
            exit();
        } else {
            // Falsches Passwort
            header("Location: login.php?message=Falsches Passwort.");
            exit();
        }
    } else {
        // Benutzer nicht gefunden
        header("Location: login.php?message=Benutzer nicht gefunden.");
        exit();
    }
}

$conn->close();
?>
