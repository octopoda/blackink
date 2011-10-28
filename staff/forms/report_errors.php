<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); 
	
	$link = 'forms/dashboard.php';
	$form_action = 'Contact Admin';
    $user = new Users($_SESSION['user_id']);
	echo $user->pushToForm();
?>

<h3>Report Errors</h3>
<form id="formUpdate"  method="POST">
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
      </fieldset>
      <fieldset>
      	<legend>What Problems Are You Experiencing?</legend>  
        <p>
        	<label for="message">Problem  (please explain step by step)</label>
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
           <input type="hidden" name="reportError" id="ReportError" value="1"  />
           <button id="confirmButton" type="submit"><?php echo $form_action; ?></button>
        </p>
    </fieldset>
</form>
<div class="data">
</div>
<div class="phpErrors">
	
</div>