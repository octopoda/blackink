<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	$users = new Users();
	
	
	
?>


<h3 class="floatLeft">Users</h3>
<p>Put information about use here.</p>

<table class="grid editable" action="/ajax/grid_ajax.php" title="Default" sel="users">
    <tr>	
        <th col="name" width="150" link="forms/users/info_users.php">Title</th>
        <th col="email" width="100">email</th>
        <th col="access" width="100" editable="select">Access</th>
    </tr>
</table>

<div class="data"></div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid();
	});
</script>

