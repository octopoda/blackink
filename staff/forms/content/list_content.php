<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	
	unset($_SESSION['errors']);
	
	$content = new Content();
	
?>


<h3 class="floatLeft">Site Content</h3>
<p><?php if (isset($_SESSION['error'])) echo $_SESSION['error']; ?></p>

<div class="list">
		<table class="grid" action="/ajax/grid_ajax.php" title="Default" sel="content" functions="content">
			<tr>	
				<th col="title" width="300" link="/forms/form_content.php">Title</th>
				<th col="created_on" width="50">Created</th>
				<th col="modified_on" width="50">Last Edited</th>
				<th col="user_id" width="50">Author</th>
				<th col="access" width="100">Access</th>
			</tr>
		</table>

</div>
<div class="data">
</div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid();
	});
</script>

