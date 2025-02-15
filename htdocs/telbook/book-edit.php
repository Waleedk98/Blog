<?php
include('config/boot.php'); 


$AID = isset($_GET['author_id']) ? $_GET['author_id'] + 0 : 0; 


$form = isset($_POST['book']) ? $_POST['book'] : [];


if (isset($form['id'])) {
    $ID = $form['id'] ;
} else {
    $ID = isset($_GET['id']) ? $_GET['id']  : 0;
}

if ($ID == 0) { 
    // Neuen Eintrag hinzufügen
    $title = "Add New book";
    $book = [];
} else { 
    // Buch bearbeiten
    $title = "Edit book";
    $result = $db->query("SELECT * FROM books WHERE id=" .$ID);
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        $book = [];
    }
}

// Formular verarbeiten, wenn Daten gesendet werden
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validierung
    if (strlen(trim($form['title'] ?? '')) <= 5) {
        $status->error("Title should be more than 5 characters.");
    }
    if (($form['genre_id'] ?? 0) == 0) {
        $status->error("Select Genre.");
    }
    if ($ID == 0 && $AID == 0) {
        $status->error("Unknown AID.");
    }

    if ($status->success()) {
        $status->info("Book successfully saved.");

        if ($ID == 0) { // Neuen Eintrag hinzufügen
            $sql = sprintf(
                "INSERT INTO books (title, author_id, genre_id, price) VALUES('%s', %d, %d, %d)",
                $db->real_escape_string(trim($form['title'] ?? '')),
                $form['genre_id'] + 0,
                $AID,
                $form['price'] ?? 0
            );
            $status->info("sql: $sql");
            $db->query($sql);
        } else { // Existierenden Eintrag aktualisieren
            $sql = sprintf(
                "UPDATE books SET title='%s', genre_id=%d, price=%d WHERE id=%d",
                db_escape($form['title'] ?? ''),
                $form['genre_id'],
                $form['price'] ?? 0,
                $ID
            );
            $status->info("sql: $sql");
            $db->query($sql);
        }
    }
} else {
    // Keine POST-Daten -> Formular mit DB-Daten befüllen
    $form = $book;
}

echo "<h1>$title</h1>";
echo $status->html();

$genres = [];
$db_genres = $db->query("SELECT * FROM genres ORDER BY ID");
while ($g = $db_genres->fetch_object()) {
    $genres[] = $g;
}

echo "<form id='book-edit-form' action='book-edit.php?pid=$AID' enctype='multipart/form-data' method='post'>";
echo "<input type='hidden' name='book[id]' value='" . htmlspecialchars($form['id'] ?? '') . "'/>"; 
echo "<p><label>Title</label><input name='book[title]' class='txt medium' value='" . htmlspecialchars($form['title'] ?? '') . "'/></p>";
echo "<p><label>Price</label><input name='book[price]' class='txt medium' value='" . htmlspecialchars($form['price'] ?? '') . "'/></p>";
echo "<p><label>Genre</label><select name='book[genre_id]' class='txt medium'>";
foreach ($genres as $gg) {
    $selected = ($form['genre_id'] ?? 0) == $gg->ID ? " selected='selected'" : '';
    echo "<option value='" . htmlspecialchars($gg->ID) . "'$selected>" . htmlspecialchars($gg->genre) . "</option>";
}
echo "</select></p>";
echo "<p><input type='submit' value='Save'/></p>";
echo "</form>";
?>
