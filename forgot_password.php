<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/require.php');
	
	if (!empty($_GET['gi'])) {
		$u_id = Users::getUsersFromGuid($_GET['gi']);
		$u = new Users($u_id);
		$action = 1; 
	} else {
		$action = 2;
	}
	
?>

<?php if ($action == 1) : ?>
<h3>Change Password for <?php echo $u->printName(); ?></h3>

<form id="formUpdate" method="POST" >
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
<?php endif; ?>
<?php if ($action == 2) : ?>
	<form id="formUpdate" method="POST" >
    	<fieldset>
        	<legend>Email on File</legend>
            <p>
            	<label for="email">Email:</label>
                <input type="email" name="email" id="email" class="email"/>
            </p>
            <p>
            	<button type="submit">Change password</button>
            </p>
            <p class="message">
            </p>
        </fieldset>
    </form>
<?php endif; ?>

<div class="data"></div>


