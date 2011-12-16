<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
?>


<script>
	$(document).ready(function () {
		$(".grid").loadGrid({
			searchBar: true,
			deleting: false	
		});
	});
</script>
<table class="grid popup" action="/ajax/grid_ajax.php" sel="drugs">
    <tr>	
        <th col="drugName">Drug Name</th>
       	<th col="published">Published</th>
        <th col="user_id">Author</th>
        <th col="modified_on">Last Edited</th>
        <th col="access">Access</th>
    </tr>
</table>



