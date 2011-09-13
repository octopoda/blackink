<?php 
	require_once('../includes/admin_require.php');
	
	$form_action = 'Contact Admin';
    $user = new Users($_SESSION['user_id']);
	echo $user->pushToForm();
?>
<p><?php if (isset($_SESSION['error'])) echo $_SESSION['error'] ?></p>
<form id="reportErrors" action="/ajax/ajax_form_submit.php" method="POST">
    <fieldset class="step">
        <legend>Are you experiencing Problems?</legend>
        <p>
             <label for="adminId">Admin ID Given with Error:</label>
             <input id="adminId" name="adminId" type="text" />
        </p>
    </fieldset>
    <fieldset class="step">
        <legend>Your Information</legend>
        <p>
            <label for ="first">First Name</label>
            <input id="first" name="first" type="text" class="required" />
        </p>
        <p>
            <label for ="last">Last Name</label>
            <input id="last" name="last" type="text" class="required" />
        </p>
        <p>
            <label for ="email">email</label>
            <input id="email" name="email" type="text" class="email" />
        </p>
        <p>
        	<label for="message">Message</label>
            <textarea rows="20" cols="40" placeholder="How did you get the Error?" name="message" id="message"></textarea>
        </p>
    </fieldset>
    <fieldset class="step">
        <legend>Confirm</legend>
        <p>
            A box marked in red indicates that a field
            is missing data or filled out with invalid data.
        </p>
        <p class="submit">
           <input type="hidden" name="adminConnect" id="adminConnect" value="1" class="camper_password"  />
           <button id="confirmButton" type="submit"><?php echo $form_action; ?></button>
        </p>
    </fieldset>
</form>
<div class="data">
</div>
<div class="phpErrors">
	
</div>