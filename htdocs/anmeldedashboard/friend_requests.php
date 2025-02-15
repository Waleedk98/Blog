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

$user_id = $_SESSION['user_id'];

// Freundschaftsanfragen abrufen
$sql_requests = "SELECT friend_requests.id, users.first_name, users.last_name, friend_requests.status 
                 FROM friend_requests 
                 JOIN users ON friend_requests.sender_id = users.id 
                 WHERE friend_requests.receiver_id = $user_id AND friend_requests.status = 'pending'";
$requests = $conn->query($sql_requests);

// Anfrage annehmen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accept_request'])) {
    $request_id = intval($_POST['request_id']);
    $sql_accept = "UPDATE friend_requests SET status = 'accepted' WHERE id = $request_id";
    $conn->query($sql_accept);
    
    header("Location: friend_requests.php");
    exit();
}

// Anfrage ablehnen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['decline_request'])) {
    $request_id = intval($_POST['request_id']);
    $sql_decline = "UPDATE friend_requests SET status = 'declined' WHERE id = $request_id";
    $conn->query($sql_decline);
    
    header("Location: friend_requests.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freundschaftsanfragen</title>
</head>
<body>
    <h1>Freundschaftsanfragen</h1>

    <?php while ($request = $requests->fetch_assoc()): ?>
        <p><?php echo htmlspecialchars($request['first_name']) . ' ' . htmlspecialchars($request['last_name']); ?> hat eine Freundschaftsanfrage gesendet.</p>
        <form action="friend_requests.php" method="post" style="display: inline;">
            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
            <button type="submit" name="accept_request">Annehmen</button>
            <button type="submit" name="decline_request">Ablehnen</button>
        </form>
    <?php endwhile; ?>
</body>
</html>
