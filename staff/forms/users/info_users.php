<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	$users = new Users();
	
	if (!empty($_GET['sel'])) {
		$u = new users($_GET['sel']);	
		$action = "Update User";
			
	} else {
		echo '<p>You have not picked a user. Please go back to search users and click a user to view.</p>';
		return;	
	}
	
	
	$phones = new Phones($u->user_id);
	$address = new Address($u->address_id);
	
	
?>

<div class="buttonSet">
	<button>Edit Information</button>
    <button>Change Password</button>
</div>
<h3 class="floatLeft"><?php echo $u->printName(); ?></h3>

<div>
	<h4>Personal Information</h4>
	<dl>
    	<dt>Email:</dt>
        	<dd><?php echo $u->email; ?></dd>
        <dt>Company:</dt>
        	<dd><?php echo $u->company; ?></dd>
		<dt>NPI Number</dt>
        	<dd><?php echo $u->NPINumber; ?></dd>   
    </dl>
    
    <h4>Location Information</h4>
    <dl>
    	<dt>Address:</dt>
        	<dd><address><?php echo $address->printAddress(); ?></address></dd>
    	<dt>Phone</dt>
        	<dd><?php echo $phones->printPhones(); ?></dd>
    </dl>
</div>

<div class="data"></div>

