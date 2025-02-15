<?php
include('config/boot.php');

$res = $db->query("
	SELECT *
	FROM STUDENTS_TBL 
	ORDER BY ID
	");
$studenten = array();
while($s = $res->fetch_object()) $studenten[] = $s;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Telbook</title>
	
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<link rel="stylesheet" type="text/css" href="css/default.css">

	<script type="text/javascript" src="js/jquery-2.1.3.js"></script>
	<script type="text/javascript" src="js/application.js"></script>
</head>
<body>
	<table class='layout'>
		<tr>
			<td class='panel'>
			<h1>Studenten</h1>
			<table class='grid'>
				<tr>
					<th>ID</th>
					<th>FAKNO</th>
					<th>NAME</th>
					<th>FAM</th>
					<th>ADDRESS</th>
					<th></th>
					<th></th>
					<th></th>
				<tr>
				<?php
					foreach($studenten as $s) {
						echo "<tr>
							<td>".$s->ID."</td>
							<td>".$s->FAKNO."</td>
							<td>".$s->NAME."</td>
							<td>".$s->FAM."</td>
							<td>".$s->ADDRESS."</td>
							<td>
								<a href='get-noten-json.php?id=".$s->ID."' class='icon view_icon student-show-noten'>Noten zeigen</a>
							</td>
							<td>
								<a href='student-edit.php?id=".$s->ID."' class='icon edit_icon student-edit'>Edit</a>
							</td>
							<td>
								<a href='student-delete.php?id=".$s->ID."' class='icon delete_icon student-delete'>Loeschen</a>
							</td>
						</tr>";
					}
				?>
			</table>
			<p>
				<a href='person-edit.php' class='icon add_icon person-edit'>Add new person</a>
				<a href='./' class='icon refresh_icon'>Refresh</a>
			</p>
			</td>
			<td class='panel'>
				<div id='student-details'>
				</div>
			</td>
		</tr>
		<tr>
			<td class='panel'>
				<h1>Telephones</h1>
				<div id='noten-list'>
					<p class='icon info_icon'>Selektieren Sie bitte einen Student, um seine Noten zu sehen.</p>
				</div>
			</td>
			<td class='panel'>
				<div id='note-details'>
				</div>
			</td>
		</tr>
	</table>
</body>
</html>