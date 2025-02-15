<?php
include('config/boot.php');

$ID = $_GET['id']+0; 

$db->query(sprintf("DELETE FROM NOTES_TBL WHERE ID=%d", $ID));

$status->info("Note geloescht.");
$status->info("SQL: $sql");
echo $status->html();
