$(document).ready(function()
	{
// ---------------------------------------------------------
	$(document).on('click', 'a.student-show-notes, a.student-refresh', function(e)
		{
		show_notes($(this).attr('href'));
		$('#notes-details').html('');
		return false;
		});
// ---------------------------------------------------------
	function show_notes(href)
		{
		$.getJSON(href, function(json_data)
			{
			var html = '';
			html += "<p class='icon user_icon'>"+
				    json_data.student.FAKNO+" "+
				    json_data.student.NAME+" "+
				    json_data.student.FAM+"</p>";
			html += "<table class='grid'>";
			html += "<tr><th>ID</th><th>SUBJECT</th><th>NOTE</th><th></th><th></th></tr>";
			$.each(json_data.notes, function(i, item)
				{
				html += 
					"<tr>"+
					"<td>"+item.ID+"</td>"+
					"<td>"+item.NAME+"</td>"+
					"<td>"+item.NOTE+"</td>"+
					"<td>"+
						"<a href='note-edit.php?id=" + (item.ID) + "' class='icon edit_icon note-edit'>Edit</a> "+
					"</td>"+
					"<td>"+
						"<a href='note-delete.php?id=" + (item.ID) + "' class='icon delete_icon note-delete'>Delete</a>"+
					"</td>"+
				"</tr>";
				});
			html += "</table>";
			html += "<p>"+
				"<a href='note-edit.php?stid=" + (json_data.notes.ID) + "' class='icon add_icon note-edit'>Add new note</a> "+
				"<a href='get-notes-json.php?id=" + (json_data.student.ID) + "' class='icon refresh_icon notes-refresh'>Refresh</a>"+
				"</p>";
			$('#notes-list').html(html);
			});
		}
// ---------------------------------------------------------
// ---------------------------------------------------------
	$(document).on('click', 'a.student-edit, a.student-delete', function(e)
		{
		$.get($(this).attr('href'), function(data)
			{
			$('#student-details').html(data);
			});
		return false;
		});
// ---------------------------------------------------------
	$(document).on('submit', '#student-edit-form', function(e)
		{
		$.post($(this).attr('action'),$(this).serialize(),function(data)
			{
			$('#student-details').html(data);
			});
		return false;
		});
// ---------------------------------------------------------
// ---------------------------------------------------------
	$(document).on('click', 'a.note-edit, a.note-delete', function(e)
		{
		$.get($(this).attr('href'), function(data)
			{
			$('#note-details').html(data);
			});
		return false;
		});
// ---------------------------------------------------------
	$(document).on('submit', '#note-edit-form', function(e)
		{
		$.post($(this).attr('action'),$(this).serialize(),function(data)
			{
			$('#note-details').html(data);
			});
		return false;
		});
// ---------------------------------------------------------
// ---------------------------------------------------------
	});