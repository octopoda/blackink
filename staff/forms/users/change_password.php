<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');
	
	if (!empty($_GET['sel'])) {
		$u = new users($_GET['sel']);	
		$action = "Update User";	
		
	} else {
		$u = new users();
		$content = new Content();
		$action = "Add User";	
	}
	
	$phones = new Phones($u->user_id);
	$address = new Address($u->address_id);
	
	echo $u->pushToForm();
	echo $address->pushToForm();
	
?>


<h3><?php echo $action; ?></h3>

<form id="formUpdate" method="POST" class="usersForm">
    <fieldset>
        <legend>Personal Details</legend>
        <p>
            <label for="first">First Name:</label>
            <input name="first" id="first" type="text" />
        </p>
        <p>
            <label for="last">Last Name:</label>
            <input type="text" name="last" id="last" />
        </p>
        <p>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" />
        </p>
        <p>
            <label for="NPINumber">NPI Number</label>
            <input type="text" name="NPINumber" id="NPINumber" />
        </p>
        <p>
            <label for="company">Company</label>
            <input type="text" name="company" id="company" />
        </p>
        
    </fieldset>
    <fieldset>
        <legend>Location Details</legend>
        <p>
            <label for="address1">Address</label>
            <input id="address1" name="address1" type="text"  class="required"  />
            <input type="hidden" name="address_id" id="address_id" /> 
        </p>
        <p>
            <label for="address2">Address</label>
            <input id="address2" name="address2" type="text"  />
        </p>
        <p>
            <label for="city">City</label>
            <input type="text" name="city" id="city"  class="required"/>
        </p>
         <p>
            <label for="state">State</label>
            <?php echo Address::stateSelect(); ?>
        </p>
         <p>
            <label for="zip">Zip Code</label>
            <input name="zip" id="zip" type="text" class="zip" />
        </p>
        </p>
            <?php echo $phones->createPhoneFields(); ?>
        <p>
    </fieldset>
    <?php if ($action == "Add Users") : ?>
    <fieldset>
        <legend>Login Details</legend>
        <p>
            <label for="password">Password</label>
            <input id="password" name="password" type="password"  class="required"  />
        </p>
        <p>
            <label for="confirmPassword">Confirm Password</label>
            <input id="confirmPasword" name="confirmPassword" type="text"  />
        </p>
    </fieldset>
    <?php endif; ?>
</form>

<div class="data"></div>


