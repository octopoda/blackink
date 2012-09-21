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
            <label for="importance">Importance:</label>
            <?php echo $u->selectBox(); ?>
        </p>
    </fieldset>




    <fieldset>
    	<button name="users"><?php echo $action; ?></button>
        <input type="hidden" name="user_id" id="user_id" />
        <input type="hidden" name="<?php echo $class; ?>" id="<?php echo $class; ?>" value="forms/users/info_users.php?sel=" />
    </fieldset>

</form>

<div class="data"></div>


