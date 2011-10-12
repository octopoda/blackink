<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	$content = new Content();
?>


<h3 class="floatLeft">Site Content</h3>
<p><?php if (isset($_SESSION['error'])) echo $_SESSION['error']; ?></p>

<div class="contentList">
		<table class="grid" action="/ajax/grid_ajax.php" title="Default" sel="content">
			<tr>	
				<th col="title" width="300" link="forms/content/form_content.php">Title</th>
                <th col="published" width="50">Published</th>
				<th col="modified_on" width="40">Last Edited</th>
				<th col="user_id" width="100">Author</th>
				<th col="access" width="40">Access</th>
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

