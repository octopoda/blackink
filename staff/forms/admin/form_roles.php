<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');

	if (!empty($_GET['sel'])) {
		$u = new UserGroups($_GET['sel']);
		$action = "Update User Group";
    } else {
		$u = new UserGroups();
		$action = "Add User Group";
    }

	echo $u->pushToForm();

?>


<h3><?php echo $action; ?></h3>

<form id="formUpdate" method="POST" class="usersForm">
    <fieldset>
        <legend>User Group</legend>
        <p>
            <label for="groupname">Group Name:</label>
            <input name="groupname" id="groupname" type="text" class="required" />
        </p>
        <p>
            <?php echo $u->positionDropDown(); ?>
        </p>
    </fieldset>




    <fieldset>
    	<button name="userGroups"><?php echo $action; ?></button>
        <input type="hidden" name="group_id" id="group_id" />
        <input type="hidden" name="userGroups" id="userGroups" value="forms/admin/list_roles.php?sel=" />
    </fieldset>

</form>

<div class="data"></div>


