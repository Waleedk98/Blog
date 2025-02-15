$(document).ready(function()
	{
// ---------------------------------------------------------
	$(document).on('click', 'a.autor-show-book, a.book-refresh', function(e)
		{
		show_tels($(this).attr('href'));
		$('#autor-details').html('');
		return false;
		});
// ---------------------------------------------------------
	function show_tels(href)
		{
		$.getJSON(href, function(json_data)
			{
			var html = '';
			html += "<p class='icon user_icon'>"+
                    json_data.autor.id+" "+
				    json_data.autor.fname+" "+
                    json_data.autor.lname+" "+
				    json_data.autor.born+"</p>";
			html += "<table class='grid'>";
			html += "<tr><th>ID</th><<th>title</th><th>genre</th><th>price</th><th>edit</th><th>löschen</th></tr>";
			$.each(json_data.book, function(i, item)
				{
				html += 
					"<tr>"+
					"<td>"+item.id+"</td>"+
                    "<td>"+item.title+"</td>"+
                    "<td>"+item.genre+"</td>"+
                    "<td>"+item.price+"</td>"+
					"<td>"+
						"<a href='book-edit.php?id=" + (item.id) + "' class='icon edit_icon book-edit'>Edit</a> "+
					"</td>"+
					"<td>"+
						"<a href='book-delete.php?id=" + (item.id) + "' class='icon delete_icon book-delete'>Delete</a>"+
					"</td>"+
				"</tr>";
				});
			html += "</table>";
			html += "<p>"+
				"<a href='book-edit.php?pid=" + (json_data.book.id) + "' class='icon add_icon book-edit'>Add new book</a> "+
				"<a href='get-book-json.php?id=" + (json_data.book.id) + "' class='icon refresh_icon book-refresh'>Refresh</a>"+
				"</p>";
			$('#book-list').html(html);
			});
		}
// ---------------------------------------------------------
// ---------------------------------------------------------
	$(document).on('click', 'a.autor-edit, a.autor-delete', function(e)
		{
		$.get($(this).attr('href'), function(data)
			{
			$('#autor-details').html(data);
			});
		return false;
		});
// ---------------------------------------------------------
	$(document).on('submit', '#autor-edit-form', function(e)
		{
		$.post($(this).attr('action'),$(this).serialize(),function(data)
			{
			$('#autor-details').html(data);
			});
		return false;
		});
// ---------------------------------------------------------
// ---------------------------------------------------------
	$(document).on('click', 'a.book-edit, a.book-delete', function(e)
		{
		$.get($(this).attr('href'), function(data)
			{
			$('#book-details').html(data);
			});
		return false;
		});
// ---------------------------------------------------------
	$(document).on('submit', '#book-edit-form', function(e)
		{
		$.post($(this).attr('action'),$(this).serialize(),function(data)
			{
			$('#book-details').html(data);
			});
		return false;
		});
// ---------------------------------------------------------
// ---------------------------------------------------------
	});