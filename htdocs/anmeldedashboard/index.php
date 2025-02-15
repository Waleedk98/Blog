<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrieren</title>
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
        .login-link {
            margin-top: 20px;
        }
        .login-link a {
            color: #1877f2;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Registrieren</h2>
        <form action="register.php" method="post">
            <input type="text" name="first_name" placeholder="Vorname" required>
            <input type="text" name="last_name" placeholder="Nachname" required>
            <input type="text" name="email" placeholder="E-Mail" required>
            <input type="password" name="password" placeholder="Passwort" required>
            <input type="submit" value="Registrieren">
        </form>

        <?php
        if (isset($_GET['message'])) {
            echo '<p class="message">' . htmlspecialchars($_GET['message']) . '</p>';
        }
        ?>

        <!-- Link zur Anmeldeseite -->
        <div class="login-link">
            <p>Bereits ein Konto? <a href="login.php">Hier anmelden</a></p>
        </div>
    </div>

</body>
</html>
