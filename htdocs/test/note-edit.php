<?php
include('config/boot.php');

$STID = $_GET['stid']+0;

$form = $_POST['note'];
if(isset($form['ID']))
	{
	$ID = $form['ID']+0;
	}
else
	{
	$ID = $_GET['id']+0;
	}

if($ID == 0)
	{ // new person, no data
	$title = "Add New Note";
	$tel = [];
	}
else if(isset($form))
	{ // save/update person
	$title = "Edit Note";
	}
else
	{ // edit student
	$title = "Edit Note";
	$result = $db->query("SELECT * FROM NOTES_TBL WHERE ID=".$ID);
	$note = $result->fetch_assoc();
	}

if(isset($_POST['note']))
	{ // if any data posted -> validate and update data
	$form = $_POST['note'];
	if($form['NOTE']>7) {
		$status->error("...........");
	}
	if(($form['SBID']+0)==0)
		{
		$status->error("Selektieren Sie ein Lehrfach.");
		}
	if($ID == 0 && $STID == 0)
		{
		$status->error("Unknown STID.");
		}

	if($status->success())
		{
		$status->info("Note successfully saved.");

		if($ID == 0)
			{ // no ID -> insert
			$sql = sprintf(
				"INSERT INTO NOTES_TBL(NOTE, SBID, STID) VALUES('%d',%d,%d)",
				$form['NOTE']+0,
				$form['SBID']+0,
				$STID
				);
			$status->info("sql: $sql");
			$db->query($sql);
			}
		else
			{ // update
			$sql = sprintf(
				"UPDATE NOTES_TBL SET NOTE='%d', SBID=%d WHERE ID=%d",
				$form['NOTE']+0,
				$form['SBID']+0,
				$ID
				);
			$status->info("sql: $sql");
			$db->query($sql);
			}
		}
	}
else
	{ // if no data submitted -> fill the form with data from the DB
	$form = $note; 
	}


echo "<h1>$title</h1>";
echo $status->html();

$subjects = [];
$db_subjects = $db->query("SELECT * FROM SUBJECTS_TBL ORDER BY ID ");
while($s = $db_subjects->fetch_object()) {$subjects[] = $s;}

echo "<form id='note-edit-form' action='note-edit.php?pid=$STID' enctype='multipart/form-data' method='post'>";
echo "<input type='hidden' name='note[ID]' value='".htmlspecialchars($form['ID'])."'/>";
echo "<p><label>Zensur</label><input name='note[NOTE]' class='txt medium' value='".htmlspecialchars($form['NOTE'])."'/></p>";
echo "<p><label>Lehrfach</label><select name='note[SBID]' class='txt medium'>";
echo "<option value=''></option>";
foreach($subjects as $s)
	{
	$selected = ($form['SBID'] == $s->ID)?" selected='selected' ":'';
	echo "<option value='$s->ID' $selected>$s->NAME</option>";
	}
echo "</select></p>";
echo "<p><input type='submit' value='Save'/></p>";
echo "</form>";
