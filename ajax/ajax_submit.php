<?php

require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/require.php');

if (isset($_POST['login'])) {
	$user = new Users();
	
	$email = trim($_POST['email']);
    $password = trim($_POST['password']);
        
    if ($user->authenticate($email, $password) == false) {
         echo "The email / password you've given do not match anything in our system.";
    }
	
	 if ($user->isLoggedIn()) {      // did we authenticate / are we already logged in?
        redirect('/index');
    }
}	


if (isset($_POST['registerUser'])) {
	$user = new Users();

	$create = $user->createUserFromForm($_POST); //Create User
	$saveUser = new Users($create);
	
	if ($user->authenticate($_POST['email'], $_POST['password'])) {
		if ($user->isLoggedIn()) redirect('/index');	
	}
	//Log in User	
}


if (isset($_POST['sendEmail'])) {
	$contact = new contactInformation();
	
	if (!isset($_POST['real'])) {
		echo "You are trying to spam us.  Please go away."; 
		return;
	}

	if ($contact->emailCompany($_POST)) {
		echo 'Your email has been sent.  Please give us 2-3 buisness days to respond.';	
	} else {
		echo "Something has gone wrong.  Please try to contact us by phone. "; 
	} 
}


if (isset($_GET['searchAutoComplete'])) {
	$display = new Display();
	$result = $display->titleSearch($_GET['q']);
	foreach($result as $row) {
		 echo $row['title']."\n";
	} 	
}

if (isset($_POST['search'])) {
	$display = new Display();
	$display->siteSearch($_POST['search'], $_POST['pageNumber']);
	
}

if (isset($_POST['forgotPassword'])) {
	echo Users::forgotPassword($_POST['email']);	
}

if (isset($_POST['changePassword'])) {
	$user = new Users($_POST['user_id']);
	$user->changePassword($_POST['newPass']);
	redirect('index.php');
}

/*if (isset($_POST['newsletterSubmit'])) {
	
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
} */	

?>