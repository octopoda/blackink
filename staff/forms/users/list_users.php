<?php require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); ?>


<h3 class="floatLeft">Users</h3>
<p>Put information about use here.</p>

<table class="grid editable" action="/ajax/grid_ajax.php" title="Default" sel="users">
    <tr>
        <th col="name" width="150" link="forms/users/info_users.php">Name</th>
        <th col="email" width="100">email</th>
        <?php if ($users->access > 4) : ?>
        <th col="access" width="100" editable="select">Access</th>
        <?php endif; ?>
    </tr>
</table>

<div class="data"></div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid();
	});
</script>

