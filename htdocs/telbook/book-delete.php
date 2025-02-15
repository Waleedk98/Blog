<?php
include('config/boot.php');

$ID = $_GET['id']; 

$db->query(sprintf("DELETE FROM books WHERE id=%d", $ID));

$status->info("book deleted.");
$status->info("SQL: $sql");
echo $status->html();
