<?php

require_once('../includes/require.php');

if (isset($_POST['selector'])) {
	$_SESSION['mainNav'] = $_POST['selector'];	
}

if (isset($_POST['setNav'])) {
	if (isset($_SESSION['mainNav'])) {
			echo $_SESSION['mainNav'];	
	}
}

if (isset($_POST['newsletterSubmit'])) {
	
	if ($_POST['email'] == '') {  echo 'No email address Provided'; return; }
	
	if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $_POST['email'])) {
		echo "Email address is invalid"; 
	}
	
	$api = new MCAPI('f0555cecd49835d6d0627a84c06271d7-us2');
	
	// grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
	// Click the "settings" link for the list - the Unique Id is at the bottom of that page. 
	$list_id = "049ae5f62e";

	if($api->listSubscribe($list_id, $_POST['email'], '') === true) {
		// It worked!	
		echo 'Success! Check your email to confirm sign up.';
		return;
	}else{
		// An error ocurred, return error message	
		echo 'Error: ' . $api->errorMessage;
		return;
	}	
}

if (isset($_POST['sendEmail'])) {

	if ($_POST['email'] == '') {
		 echo 'Please fill out your email'; 
		 return;
	}
	
	if(!preg_match("/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/", $_POST['email'])) {
		echo "Email address is invalid"; 
		return;
	}
	
	if ($_POST['name'] == '') {
		echo "Please provide us your name"; 
		return;
	}
	
	if ($_POST['subject'] == '') {
		echo "Please provide a subject to  your email"; 
		return;
	}
	
	if ($_POST['message'] == '') {
		echo "Please tell us why you are contacting us"; 
		return;
	}
	
	if ($_POST['address'] != '') {
		echo "You are trying to spam us.  Please go away"; 
		return;
	}

	if (contactCadence($_POST)) {
		echo 'success';	
	} else {
		echo "Somethings gone wrong.  Please try to contact us by phone. "; 
	}
}	

?>