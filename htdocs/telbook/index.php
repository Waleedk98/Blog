<?php
include('config/boot.php');

$res = $db->query("
	SELECT *
	FROM authors 
	ORDER BY id
	");
$autor = array();
while($a = $res->fetch_object()) {
	$autor[] = $a;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Autorenlist</title>
	
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<link rel="stylesheet" type="text/css" href="css/default.css">

	<script type="text/javascript" src="js/jquery-2.1.3.js"></script>
	<script type="text/javascript" src="js/application.js"></script>
</head>
<body>
	<table class='layout'>
		<tr>
			<td class='panel'>
			<h1>Autoren</h1>
			<table class='grid'>
				<tr>
					<th>ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Born</th>
					<th>show Books</th>
					<th>edit</th>
					<th>delete</th>
				<tr>
				<?php
					foreach($autor as $a) {
						echo "<tr>
							<td>".$a->id."</td>
							<td>".$a->fname."</td>
							<td>".$a->lname."</td>
							<td>".$a->born."</td>
							<td>
								<a href='get-autor-json.php?id=".$a->id."' class='icon view_icon autor-show-book'>Show Books</a>
							</td>
							<td>
								<a href='autor-edit.php?id=$a->id' class='icon edit_icon autor-edit'>Edit</a>
							</td>
							<td>
								<a href='autor-delete.php?id=$a->id' class='icon delete_icon autor-delete'>Delete</a>
							</td>
						</tr>";
					}
				?>
			</table>
			<p>
				<a href='autor-edit.php' class='icon add_icon student-edit'>Add new Autor</a>
				<a href='./' class='icon refresh_icon'>Refresh</a>
			</p>
			</td>
			<td class='panel'>
				<div id='autor-details'>
				</div>
			</td>
		</tr>
		<tr>
			<td class='panel'>
				<h1>Bücherübersicht</h1>
				<div id='book-list'>
					<p class='icon info_icon'>Select a Autor to view his books.</p>
				</div>
			</td>
			<td class='panel'>
				<div id='book-details'>
				</div>
			</td>
		</tr>
	</table>
</body>
</html>