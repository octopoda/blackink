<?php require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); ?>


<h3 class="floatLeft">Main Menu Navigation</h3>
<p><?php if (isset($_SESSION['error'])) echo $_SESSION['error']; ?></p>

<div class="list">
		<table class="grid" action="/ajax/grid_ajax.php" title="Default" sel="navigation">
			<tr>	
				<th col="title" width="300">Title</th>
				<th col="published" width="50" class="published">Published</th>
				<th col="link" width="50">Last Edited</th>
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

