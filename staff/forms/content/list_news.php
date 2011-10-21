<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	$content = new Content();
?>

<ul class="quickMenu">
	<li><a href="forms/content/form_news.php" class="redirect">
		<span class="ninjaSymbol ninjaSymbolPlus"></span>
		<span class="text"> Add News</span>
		</a>
	</li>
</ul>

<h3>News</h3>
<p></p>
<table class="grid" action="/ajax/grid_ajax.php" title="Default" sel="news">
    <tr>	
        <th col="title" width="250" link="forms/content/form_news.php">Title</th>
        <th col="published" width="50" link="forms/content/list_news">Published</th>
        <th col="created_on" width="40">Created On</th>
        <th col="user_id" width="100">Author</th>
        <th col="access" editable="select" width="100">Access</th>
    </tr>
</table>
<div class="data">
</div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid();
	});
</script>

