<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');
	
	if (!empty($_GET['sel'])) {
		$u = new users($_GET['sel']);	
		$action = "Change Password";	
		
	} else {
		$u = new users();
		$content = new Content();
		$action = "Change Password";	
	}
	
	$phones = new Phones($u->user_id);
	$address = new Address($u->address_id);
	
	echo $u->pushToForm();
	echo $address->pushToForm();
	
?>


<h3>Change Password</h3>

<form id="formUpdate" method="POST" class="validate">
    <fieldset class="step">
        <legend>Original Password</legend>
        <p>
             <label for="origPass">Password</label>
             <input id="origPass" name="origPass" type="password" class="required" sel="<?php echo $u->user_id ?>" title="camper" />
             <input type="hidden" name="camper_id" value="<?php echo $u->user_id ?>">
        </p>
    </fieldset>
    
    
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
           <input type="hidden" name="camperPassword" value="1"  />
           <button id="confirmButton" type="submit"><?php echo $action; ?></button>
        </p>
    </fieldset>
</form>

<div class="data"></div>


