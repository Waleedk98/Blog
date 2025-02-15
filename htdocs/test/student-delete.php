<?php
include('config/boot.php');
$ID = $_GET['id']+0;

// delete telephones
$db->query(sprintf("DELETE FROM NOTES_TBL WHERE STID=%d", $ID));
// delete person
$sql = sprintf("DELETE FROM STUDENTS_TBL WHERE ID=%d", $ID);
$db->query($sql);

$status->info("Student geloescht.");
$status->info("SQL: $sql");
echo $status->html();
