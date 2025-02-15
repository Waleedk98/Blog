<?php
include('config/boot.php');

$form = $_POST['student'];
if(isset($form['ID']))
    {
    $STID = $form['ID']+0;
    }
else
    {
    $STID = $_GET['id']+0;
    }

if($STID == 0)
    { // new person, no data
    $title = "Add New Student";
    $student = array();
    }
else if(isset($form))
    { // save/update person
    $title = "Edit Person";
    }
else
    { // edit person
    $title = "Edit Person";
    $result = $db->query("
		SELECT *
		FROM STUDENTS_TBL
		WHERE ID = ".($STID)."
	    ");
    $student = $result->fetch_assoc();
   }

if(isset($_POST['student']))
    { // if any data posted -> validate and update data
    $form = $_POST['student'];
    if(strlen(trim($form['FAKNO']))<>7)
		$status->error("FAKNO muss genau 7 Zeichen lang sein.");
    if(strlen(trim($form['NAME']))<=1)
		$status->error("NAME should be more than 1 character.");
	if(strlen(trim($form['FAM']))<=1)
		$status->error("FAM should be more than 1 character.");
	if(strlen(trim($form['ADDRESS']))<=5)
		$status->error("ADDRESS should be more than 5 characters.");

	if($status->success())
		{
		if($STID == 0)
			{ // no ID -> insert
			$db->query(sprintf(
				"INSERT INTO STUDENTS_TBL(FAKNO, NAME, FAM, ADDRESS) VALUES('%d','%s','%s','%s')",
				db_escape($form['FAKNO']),
				db_escape($form['NAME']),
				db_escape($form['FAM']),
				db_escape($form['ADDRESS'])
				));

			$status->info("Student erfolgreich gespreichert.");
			}
		else
			{ // update
			$db->query(sprintf(
				"UPDATE STUDENTS_TBL SET FAKNO='%d', NAME='%s', FAM='%s', ADDRESS='%s'
				WHERE ID=%d",
				$db->real_escape_string(trim($form['FAKNO'])),
				$db->real_escape_string(trim($form['NAME'])),
				$db->real_escape_string(trim($form['FAM'])),
				$db->real_escape_string(trim($form['ADDRESS'])),
				$STID
				));
			$status->info("Person successfully updated.");
			}
		}
	}
else
	{ // if no data submitted -> fill the form with data from the DB
	$form = $student; 
	}

echo "<h1>$title</h1>";
echo $status->html();

echo "<form id='student-edit-form' action='student-edit.php' enctype='multipart/form-data' method='post'>";
echo "<input type='hidden' name='student[ID]' value='".htmlspecialchars($form['ID'])."'/>";
echo "<p><label>NAME</label><input name='student[FAKNO]' class='txt medium' value='".htmlspecialchars($form['FAKNO'])."'/></p>";
echo "<p><label>NAME</label><input name='student[NAME]' class='txt medium' value='".htmlspecialchars($form['NAME'])."'/></p>";
echo "<p><label>FAM</label><input name='student[FAM]' class='txt medium' value='".htmlspecialchars($form['FAM'])."'/></p>";
echo "<p><label>ADDRESS</label><input name='student[ADDRESS]' class='txt medium' value='".htmlspecialchars($form['ADDRESS'])."'/></p>";
echo "<p><input type='submit' value='Save'/></p>";
echo "</form>";
