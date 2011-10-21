<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	$content = new Content();
?>


<h3>Site Content</h3>

<table class="grid" action="/ajax/grid_ajax.php" title="Default" sel="content">
    <tr>	
        <th col="title" width="250" link="forms/content/form_content.php">Title</th>
        <th col="published" width="50">Published</th>
        <th col="modified_on" width="40">Last Edited</th>
        <th col="user_id" width="100">Author</th>
        <th col="access" editable="select" width="100">Access</th>
    </tr>
</table>
<div class="data"></div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid();
	});
</script>

