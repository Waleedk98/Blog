<?php
include('config/boot.php');

$form = $_POST['autor'];
if(isset($form['id']))
    {
    $AID = $form['id']+0;
    }
else
    {
    $AID = $_GET['id']+0;
    }

if($AID == 0)
    { // new person, no data
    $title = "Add New Autor";
    $autor = array();
    }
else if(isset($form))
    { // save/update person
    $title = "Edit Autor";
    }
else
    { // edit person
    $title = "Edit Autor";
    $result = $db->query("
		SELECT *
		FROM authors
		WHERE id = ".($AID)."
	    ");
    $autor = $result->fetch_assoc();
   }

if(isset($_POST['autor']))
    { // if any data posted -> validate and update data
    $form = $_POST['autor'];
    if(strlen(trim($form['fname']))<=1)
		$status->error("FIRST NAME should be more than 1 character.");
	if(strlen(trim($form['lname']))<=1)
		$status->error("Last Name should be more than 1 character.");
	if(strlen(trim($form['born']))<=3)
		$status->error("BDAY should be more than 3 characters.");

	if($status->success())
		{
		$status->info("Autor successfully saved.");

		if($AID == 0)
			{ // no ID -> insert
			$db->query(sprintf(
				"INSERT INTO authors (fname, lname, born) VALUES('%s','%s','%d')",
				db_escape($form['fname']),
				db_escape($form['lname']),
				db_escape($form['born'])
				));
			}
		else
			{ // update
			$db->query(sprintf(
				"UPDATE authors SET fname='%s', lname='%s', born='%d'
				WHERE id=%d",
				$db->real_escape_string(trim($form['fname'])),
				$db->real_escape_string(trim($form['lname'])),
				$db->real_escape_string(trim($form['born'])),
				$AID
				));
			}
		}
	}
else
	{ // if no data submitted -> fill the form with data from the DB
	$form = $autor; 
	}

echo "<h1>$title</h1>";
echo $status->html();

echo "<form id='autor-edit-form' action='autor-edit.php' enctype='multipart/form-data' method='post'>";
echo "<input type='hidden' name='autor[id]' value='".htmlspecialchars($form['id'])."'/>";
echo "<p><label>fname</label><input name='autor[fname]' class='txt medium' value='".htmlspecialchars($form['fname'])."'/></p>";
echo "<p><label>lname</label><input name='autor[lname]' class='txt medium' value='".htmlspecialchars($form['lname'])."'/></p>";
echo "<p><label>born</label><input name='autor[born]' class='txt medium' value='".htmlspecialchars($form['born'])."'/></p>";
echo "<p><input type='submit' value='Save'/></p>";
echo "</form>";
