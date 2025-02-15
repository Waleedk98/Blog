<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Verbindung zur Datenbank
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "user_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Pfad, wo die Dateien gespeichert werden sollen
$uploadDir = "uploads/";

// Beitrag erstellen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_content'])) {
    $post_content = $conn->real_escape_string($_POST['post_content']);
    $user_id = $_SESSION['user_id'];
    $mediaPath = NULL;

    // Überprüfen, ob eine Datei hochgeladen wurde
    if (!empty($_FILES['media']['name'])) {
        $fileName = basename($_FILES['media']['name']);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Nur bestimmte Dateiformate zulassen (Bilder und Dokumente)
        $allowedTypes = array('jpg', 'png', 'jpeg', 'gif', 'mp4', 'avi', 'mkv', 'pdf', 'doc', 'docx', 'txt');
        if (in_array($fileType, $allowedTypes)) {
            // Datei auf den Server hochladen
            if (move_uploaded_file($_FILES['media']['tmp_name'], $targetFilePath)) {
                $mediaPath = $targetFilePath; // Dateipfad speichern
            } else {
                echo "Es gab ein Problem beim Hochladen der Datei.";
            }
        } else {
            echo "Nur Dateien in den Formaten JPG, PNG, JPEG, GIF, MP4, AVI, MKV, PDF, DOC, DOCX, TXT sind erlaubt.";
        }
    }

    // Beitrag mit oder ohne Medien speichern
    $sql = "INSERT INTO posts (user_id, content, media) VALUES ('$user_id', '$post_content', '$mediaPath')";
    $conn->query($sql);
    
    // Umleitung nach dem Posten
    header("Location: dashboard.php");
    exit();
}

// Kommentar erstellen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment_content'])) {
    $comment_content = $conn->real_escape_string($_POST['comment_content']);
    $post_id = intval($_POST['post_id']);
    $user_id = $_SESSION['user_id'];

    // Kommentar speichern mit aktuellem Zeitstempel
    $sql_comment = "INSERT INTO comments (user_id, post_id, comment) VALUES ('$user_id', '$post_id', '$comment_content')";
    $conn->query($sql_comment);

    // Umleitung nach dem Kommentieren
    header("Location: dashboard.php");
    exit();
}

// Beitrag löschen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_post_id'])) {
    $post_id = intval($_POST['delete_post_id']);
    
    // Überprüfen, ob der aktuelle Benutzer der Verfasser des Beitrags ist
    $user_id = $_SESSION['user_id'];
    $checkPostOwner = "SELECT user_id FROM posts WHERE id = '$post_id'";
    $result = $conn->query($checkPostOwner);
    $postOwner = $result->fetch_assoc();

    if ($postOwner && $postOwner['user_id'] == $user_id) {
        // Zuerst die Kommentare zu diesem Post löschen
        $conn->query("DELETE FROM comments WHERE post_id = '$post_id'");
        // Dann den Post löschen
        $sql = "DELETE FROM posts WHERE id = '$post_id'";
        $conn->query($sql);
    }

    // Umleitung nach dem Löschen
    header("Location: dashboard.php");
    exit();
}

// Kommentar löschen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_comment_id'])) {
    $comment_id = intval($_POST['delete_comment_id']);
    $sql = "DELETE FROM comments WHERE id = '$comment_id'";
    $conn->query($sql);
    
    // Umleitung nach dem Löschen
    header("Location: dashboard.php");
    exit();
}

// Beiträge abrufen
$posts = $conn->query("SELECT posts.id, posts.content, posts.media, posts.created_at, users.first_name, users.id as user_id FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.id DESC");
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ebee;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #1877f2;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            margin: 0;
            font-size: 24px;
        }
        .logout-btn {
            background-color: white;
            color: #1877f2;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .logout-btn:hover {
            background-color: #f0f0f0;
        }
        .profile-btn {
            background-color: white;
            color: #1877f2;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
            text-decoration: none; /* Entfernt die Unterstreichung */
            display: inline-block; /* Stellt sicher, dass der Link als Block angezeigt wird */
            margin-left: 10px; /* Abstand zwischen den Buttons */
        }
        .profile-btn:hover {
            background-color: #f0f0f0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .post-form textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .post-form input[type="file"] {
            margin-bottom: 10px;
        }
        .post-form button {
            background-color: #1877f2;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .post-form button:hover {
            background-color: #145dbf;
        }
        .post {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .post strong {
            color: #1877f2;
        }
        .media {
            margin-top: 10px;
        }
        .media img, .media video {
            max-width: 100%;
            border-radius: 8px;
        }
        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            position: absolute;
            bottom: 15px;
            right: 15px;
            transition: background-color 0.3s ease;
        }
        .delete-btn:hover {
            background-color: #c90000;
        }
        .comment {
            background-color: #ececec;
            padding: 12px;
            border-radius: 8px;
            margin-top: 10px;
        }
        .comment-form textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-bottom: 10px;
        }
        .comment-form button {
            background-color: #1877f2;
            color: white;
            padding: 8px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .comment-actions {
            display: flex;
            justify-content: flex-end;
        }
        .delete-comment-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.3s ease;
        }
        .delete-comment-btn:hover {
            background-color: #c90000;
        }
    </style>
</head>
<body>

<header>
    <h1>Willkommen, <?php echo htmlspecialchars($_SESSION['first_name']); ?>!</h1>
    <div>
        <form action="logout.php" method="post" style="display: inline;">
            <button class="logout-btn" type="submit">Logout</button>
        </form>
        <a class="profile-btn" href="profile.php">Zum Profil</a>
    </div>
</header>

<div class="container">
    <h2>Neuen Beitrag erstellen:</h2>
    <form class="post-form" action="dashboard.php" method="post" enctype="multipart/form-data">
        <textarea name="post_content" rows="4" placeholder="Schreibe etwas..." required></textarea><br>
        <input type="file" name="media"><br>
        <button type="submit">Beitrag erstellen</button>
    </form>

    <h2>Beiträge:</h2>
    <?php while ($post = $posts->fetch_assoc()): ?>
        <div class="post">
            <strong><?php echo htmlspecialchars($post['first_name']); ?>:</strong>
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            <?php if ($post['media']): ?>
                <div class="media">
                    <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $post['media'])): ?>
                        <img src="<?php echo htmlspecialchars($post['media']); ?>" alt="Post Media">
                    <?php elseif (preg_match('/\.(mp4|avi|mkv)$/i', $post['media'])): ?>
                        <video controls>
                            <source src="<?php echo htmlspecialchars($post['media']); ?>" type="video/mp4">
                            Ihr Browser unterstützt das Video-Tag nicht.
                        </video>
                    <?php else: ?>
                        <a href="<?php echo htmlspecialchars($post['media']); ?>" target="_blank">Datei herunterladen</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <p><em>Veröffentlicht am: <?php echo $post['created_at']; ?></em></p>
            <?php if ($post['user_id'] == $_SESSION['user_id']): ?>
                <form action="dashboard.php" method="post" style="display: inline;">
                    <input type="hidden" name="delete_post_id" value="<?php echo $post['id']; ?>">
                    <button class="delete-btn" type="submit">Beitrag löschen</button>
                </form>
            <?php endif; ?>
            
            <!-- Kommentare anzeigen -->
            <h4>Kommentare:</h4>
            <?php
                $post_id = $post['id'];
                $comments = $conn->query("SELECT comments.id, comments.comment, comments.created_at, users.first_name, comments.user_id FROM comments JOIN users ON comments.user_id = users.id WHERE comments.post_id = '$post_id'");
                while ($comment = $comments->fetch_assoc()):
            ?>
                <div class="comment">
                    <strong><?php echo htmlspecialchars($comment['first_name']); ?>:</strong>
                    <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                    <p><em>Veröffentlicht am: <?php echo $comment['created_at']; ?></em></p>
                    <div class="comment-actions">
                        <?php if ($comment['user_id'] == $_SESSION['user_id']): ?>
                            <form action="dashboard.php" method="post" style="display: inline;">
                                <input type="hidden" name="delete_comment_id" value="<?php echo $comment['id']; ?>">
                                <button class="delete-comment-btn" type="submit">Löschen</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
            
            <!-- Kommentarformular -->
            <form class="comment-form" action="dashboard.php" method="post">
                <textarea name="comment_content" rows="2" placeholder="Schreibe einen Kommentar..." required></textarea><br>
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <button type="submit">Kommentar hinzufügen</button>
            </form>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
