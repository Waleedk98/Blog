<?php
session_start();

// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "user_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Aktuellen Benutzer identifizieren
$user_id = $_GET['user_id'] ?? $_SESSION['user_id'];
if (!$user_id) {
    die("Benutzer nicht authentifiziert.");
}

// Prüfen, ob ein Profil existiert
$profile_query = "SELECT users.first_name, users.last_name, profile.bio, profile.location, profile.birthdate, profile.profile_picture 
FROM users 
LEFT JOIN profile ON users.id = profile.user_id 
WHERE users.id = '$user_id'";

$profile_result = $conn->query($profile_query);
$profile = $profile_result->fetch_assoc();

// Wenn kein Profil existiert, erstellen
if (!$profile['bio'] && !$profile['location'] && !$profile['birthdate'] && !$profile['profile_picture']) {
    $default_bio = "Hier steht eine kurze Beschreibung.";
    $default_location = "Unbekannt";
    $default_birthdate = "2000-01-01";  // Ein Standarddatum für Geburtsdatum

    $insert_profile_query = "INSERT INTO profile (user_id, bio, location, birthdate, profile_picture) 
                             VALUES ('$user_id', '$default_bio', '$default_location', '$default_birthdate', '')";

    if ($conn->query($insert_profile_query) === TRUE) {
        echo "Profil wurde erfolgreich erstellt!";
        // Neue Profilinformationen abrufen
        $profile_result = $conn->query($profile_query);
        $profile = $profile_result->fetch_assoc();
    } else {
        die("Fehler beim Erstellen des Profils: " . $conn->error);
    }
}

// Profilbearbeitung nur für den eigenen Nutzer
$is_owner = ($user_id == $_SESSION['user_id']);

// Freundschaftsanfrage-Status überprüfen
$friendship_query = "SELECT * FROM friend_requests WHERE sender_id = '{$_SESSION['user_id']}' AND receiver_id = '$user_id'";
$friendship_result = $conn->query($friendship_query);
$friendship_exists = $friendship_result->num_rows > 0;

// Freundschaftsanfrage senden
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_friend_request']) && !$friendship_exists) {
    $send_request = "INSERT INTO friend_requests (sender_id, receiver_id) VALUES ('{$_SESSION['user_id']}', '$user_id')";
    if ($conn->query($send_request)) {
        echo "Freundschaftsanfrage gesendet!";
        header("Location: profile.php?user_id=$user_id"); // Seite neu laden, um doppelte Anfragen zu vermeiden
        exit();
    } else {
        echo "Fehler beim Senden der Freundschaftsanfrage!";
    }
}

// Profil bearbeiten
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile']) && $is_owner) {
    $bio = $conn->real_escape_string($_POST['bio']);
    $location = $conn->real_escape_string($_POST['location']);
    $birthdate = $_POST['birthdate'];

    // Profilbild verarbeiten
$profile_picture = $profile['profile_picture'];
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
    $upload_dir = "/Applications/MAMP/htdocs/anmeldedashboard/profile_pictures/"; // Absoluter Pfad zum Speichern
    $profile_picture_name = basename($_FILES["profile_picture"]["name"]);
    $target_file = $upload_dir . $profile_picture_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

    // Überprüfen, ob die Datei vom richtigen Typ ist
    if (in_array($imageFileType, $allowed_types)) {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            // Setze den relativen Pfad für die Datenbank
            $profile_picture = "profile_pictures/" . $profile_picture_name;
            echo "Profilbild erfolgreich hochgeladen!";
        } else {
            echo "Fehler beim Hochladen des Profilbildes!";
            error_log("Fehler beim Verschieben der Datei. Prüfe die Berechtigungen des Zielverzeichnisses.");
        }
    } else {
        echo "Nur JPG, JPEG, PNG und GIF-Dateien sind erlaubt.";
    }
} else {
    if ($_FILES['profile_picture']['error'] !== 0) {
        echo "Fehler beim Upload: " . $_FILES['profile_picture']['error'];
    }
}


    // Datenbank aktualisieren
    $update_query = "UPDATE profile SET bio='$bio', location='$location', birthdate='$birthdate', profile_picture='$profile_picture' WHERE user_id='$user_id'";
    if ($conn->query($update_query)) {
        echo "Profil erfolgreich aktualisiert!";
        header("Location: profile.php?user_id=$user_id"); // Verhindert erneutes Posten bei Neuladen
        exit();
    } else {
        echo "Fehler beim Aktualisieren des Profils!";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilseite</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e9ebee;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4267B2;
            padding: 15px;
            color: white;
            text-align: center;
            position: relative;
        }

        header h1 {
            margin: 0;
        }

        .dashboard-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: #4267B2;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }

        .dashboard-btn:hover {
            background-color: #365899;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
        }

        .profile-header img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
        }

        .profile-info {
            flex-grow: 1;
            margin-left: 20px;
        }

        .profile-info h2 {
            margin: 0;
            color: #4267B2;
        }

        .friend-btn {
            background-color: #4267B2;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .friend-btn:hover {
            background-color: #365899;
        }

        .profile-details {
            margin-top: 20px;
        }

        .profile-details label {
            font-weight: bold;
        }

        .profile-details p {
            margin: 10px 0;
        }

        .edit-profile-form textarea {
            width: 100%;
            height: 80px;
            margin-bottom: 15px;
        }

        .edit-profile-form input[type="text"],
        .edit-profile-form input[type="date"],
        .edit-profile-form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .edit-profile-form button {
            background-color: #4267B2;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-profile-form button:hover {
            background-color: #365899;
        }
    </style>
</head>
<body>

<header>
    <h1>Profilseite</h1>
    <!-- Dashboard-Button oben rechts -->
    <a href="dashboard.php" class="dashboard-btn">Zum Dashboard</a>
</header>

<div class="container">
    <div class="profile-header">
        <div>
            <img src="<?php echo htmlspecialchars($profile['profile_picture'] ? $profile['profile_picture'] : 'https://via.placeholder.com/120'); ?>" alt="Profilbild">
        </div>
        <div class="profile-info">
            <h2><?php echo htmlspecialchars($profile['first_name']) . " " . htmlspecialchars($profile['last_name']); ?></h2>
            <p>Wohnort: <?php echo htmlspecialchars($profile['location'] ?? 'Nicht angegeben'); ?></p>
            <p>Geburtsdatum: <?php echo htmlspecialchars($profile['birthdate'] ?? 'Nicht angegeben'); ?></p>
        </div>
        <?php if (!$is_owner && !$friendship_exists): ?>
            <form action="profile.php?user_id=<?php echo $user_id; ?>" method="post">
                <button type="submit" name="send_friend_request" class="friend-btn">Freundschaftsanfrage senden</button>
            </form>
        <?php endif; ?>
    </div>

    <?php if ($is_owner): ?>
    <div class="profile-details">
        <h3>Profil bearbeiten</h3>
        <form action="profile.php?user_id=<?php echo $user_id; ?>" method="post" enctype="multipart/form-data" class="edit-profile-form">
            <label for="bio">Biografie</label>
            <textarea name="bio"><?php echo htmlspecialchars($profile['bio']); ?></textarea>

            <label for="location">Wohnort</label>
            <input type="text" name="location" value="<?php echo htmlspecialchars($profile['location']); ?>">

            <label for="birthdate">Geburtsdatum</label>
            <input type="date" name="birthdate" value="<?php echo htmlspecialchars($profile['birthdate']); ?>">

            <label for="profile_picture">Profilbild ändern</label>
            <input type="file" name="profile_picture">

            <button type="submit" name="update_profile">Profil aktualisieren</button>
        </form>
    </div>
    <?php endif; ?>
</div>

</body>
</html>
