<?php
include('config/boot.php');
$ID = $_GET['id']+0;

// delete telephones
$db->query(sprintf("DELETE FROM books WHERE author_id=%d", $ID));
// delete person
$sql = sprintf("DELETE FROM authors WHERE id=%d", $ID);
$db->query($sql);

$status->info("Person deleted.");
$status->info("SQL: $sql");
echo $status->html();
