<?php
include('config/boot.php');

$student_id = $_GET['id'] + 0;

$dbcursor = $db->query("
	SELECT ID, FAKNO, NAME, FAM
	FROM STUDENTS_TBL
	WHERE ID = '$student_id'
	");

$student = $dbcursor->fetch_object();

$dbcursor = $db->query("
   SELECT N.ID, N.STID, S.NAME, N.NOTE
   FROM NOTES_TBL N, SUBJECTS_TBL S
   WHERE N.STID='$student_id' AND N.SBID = S.ID
   ");

$noten = [];
while($help = $dbcursor->fetch_object()) {$noten[] = $help;}

$response = new stdClass();
$response->student = $student;
$response->noten = $noten;

echo json_encode($response);

/*
$person_name = $_GET['name']; // + 0;

$QueryText = sprintf("
	SELECT ID, NAME, FAM
	FROM PERSONS_TBL
	WHERE NAME = $person_name
	");

var_dump($QueryText);

$dbcursor = $db->query($QueryText);

$persons = [];
while($help = $dbcursor->fetch_object()) {$persons[] = $help;}

var_dump($persons);


//$person = $dbcursor->fetch_object();

exit;
*/
?>
