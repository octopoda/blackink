<?php require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); ?>


<h3 class="floatLeft">User Groups</h3>
<p>User roles for site and access to different pages. </p>

<table class="grid editable" action="/ajax/grid_ajax.php" title="Default" sel="userGroups">
    <tr>
        <th col="groupname" width="150" link="forms/admin/form_roles.php">Group Name</th>
        <th col="position" width="150">Importance</th>
    </tr>
</table>

<div class="data"></div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid({
            order_by: 'position'
        });
	});
</script>

