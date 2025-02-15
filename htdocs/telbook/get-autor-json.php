<?php
include('config/boot.php');

$autor_id = $_GET['id'] + 0;

$dbcursor = $db->query("
	SELECT id, fname, lname, born
	FROM authors
	WHERE ID = '$autor_id'
	");

$autor = $dbcursor->fetch_object();

$dbcursor = $db->query("
   SELECT B.id, B.author_id, G.genre, B.title, B.price
   FROM books B, genres G
   WHERE B.author_id='$autor_id' AND B.genre_id = G.id
   ");

$book = [];
while($help = $dbcursor->fetch_object()) {$book[] = $help;}

$response = new stdClass();
$response->autor = $autor;
$response->book = $book;

echo json_encode($response);
?>
