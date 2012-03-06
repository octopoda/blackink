<?php

require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/require.php');

//print_r($_POST);

if (isset($_POST['login'])) {
	$user = new Users();
	
	$email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $err = NULL;
	$refer = NULL;    
	
	if ($user->authenticate($email, $password) == false) {
	    $err = "The email / password you've given do not match anything in our system.";
    }
	
	 if ($user->isLoggedIn()) {      // did we authenticate / are we already logged in?
       $refer = $_POST['refer'];
    }
	
	echo json_encode(array(
		'error'=> $err,
		'refer'=> $refer
	));
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
	$search = new Search();
	$result = $search->titleSearch($_GET['q']);
	foreach($result as $row) {
		 echo $row['title']."\n";
	} 	
}

if (isset($_POST['pageNumber'])) {
	$display = new SiteDisplay();
	
	if ($_POST['search'] != false) {
		$search->siteSearch($_POST['search'], $_POST['pageNumber']);
		return;
	} else {
		if ($_POST['classname'] == 'post') {
			$orderBy = 'publish_date';
			$rate = 'DESC';	
		}
		$display->paginateClass($_POST['classname'], $_POST['pageNumber'], $orderBy, $rate);	
	}

	
}

if (isset($_POST['forgotPassword'])) {
	echo Users::forgotPassword($_POST['email']);	
}

if (isset($_POST['changePassword'])) {
	$user = new Users($_POST['user_id']);
	$user->changePassword($_POST['newPass']);
	redirect('index.php');
}



?>