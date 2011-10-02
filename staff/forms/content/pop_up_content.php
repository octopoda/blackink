<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	$content = new Content();
?>


<script>
	$(document).ready(function () {
		$(".grid").loadGrid({
			searchBar: true,	
		});
	});
</script>
<table class="grid popup" action="/ajax/grid_ajax.php"  sel="content">
    <tr>	
        <th col="title" width="300" class="popUpTitle">Title</th>
        <th col="published" width="40">Published</th>
        <th col="created_on" width="50">Created</th>
        <th col="modified_on" width="50">Last Edited</th>
        <th col="user_id" width="50">Author</th>
        <th col="access" width="50">Access</th>
    </tr>
</table>



