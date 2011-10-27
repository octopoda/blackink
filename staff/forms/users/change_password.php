<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');
	
	if (!empty($_GET['sel'])) {
		$u = new users($_GET['sel']);	
		$action = 1;	
		
	} else {
		$u = new users($users->user_id);
		$action = 2;	
	}
	
	echo $u->pushToForm();
	
?>


<h3>Change Password for <?php echo $u->printName(); ?></h3>

<form id="formUpdate" method="POST" >
    <?php if ($action == "2") : ?>
    <fieldset class="step">
        <legend>Original Password</legend>
        <p>
             <label for="origPass">Password</label>
             <input id="origPass" name="origPass" type="password" class="checkPassword" sel="<?php echo $u->user_id ?>" />
             
        </p>
    </fieldset>
    <?php endif; ?>
    
    <fieldset class="step">
        <legend>New Password</legend>
        <p>
            <label for ="newPass">New Password</label>
            <input id="newPass" name="newPass" type="password" class="required" />
            
        </p>
        <p>
            <label for ="verifyPass">Verify Password</label>
            <input id="verifyPass" name="verifyPass" type="password" class="equalTo" />
        </p>
    </fieldset>
    
    
    <fieldset class="step">
        <p>
            A box marked in red indicates that a field
            is missing data or filled out with invalid data.
        </p>
        <p class="submit">
        	<input type="hidden" name="user_id" value="<?php echo $u->user_id ?>">
           <input type="hidden" name="changePassword" value="forms/users/info_users.php?sel=<?php echo $u->user_id; ?>"  />
           <button type="submit"><?php echo "Change Password"; ?></button>
        </p>
    </fieldset>
</form>

<div class="data"></div>


