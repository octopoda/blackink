<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/require.php'); 

//echo 'hello';
//print_r($_POST);


//Published Ajax Control
if (isset($_POST['publishedId'])) {
	$pubId = $_POST['publishedId'];
	$className = ucfirst($_POST['class']);	
	$pub = false;
	
	if (isset($_POST['published'])) $pub = true;
	$class = new $className($pubId);
	
	if ($pub) $class->unpublish();
	else $class->publish();	
	
	$class = new $className($pubId);
	
	$id = $class->indirectId();
	echo $class->published($id);
}


//Move position Ajax control
if (isset($_POST['move'])) {
	$className = $_POST['class'];
	$class = new $className($_POST['id']);
	$newPosition = $_POST['position'];
	
	
	if ($_POST['move'] == 'moveUp') $newPosition--;
	else $newPosition++;
	
	if (isset($_POST['parent']) && isset($_POST['menu_id'])) {
		$class->setPosition($newPosition, $class->position, $_POST['parent'], $_POST['menu_id']);
	} else {
		$class->setPosition($newPosition, $class->position);
	}	
	
	
	echo $_POST['href'];	
}


//Quick Edit Ajax Control
if (isset($_POST['quickEdit'])) {
	$className = $_POST['class'];
	$class = new $className($_POST['id']);
	
	$class->fillFromForm($_POST);
	$class->$_POST['name'] = $_POST['value'];	
	$id = $class->save($class->indirectId());
	
	if ($id != null) 
		echo $_POST['href'];
}

//Delete Control
if (isset($_POST['deleter'])) {
	$className = $_POST['class'];
	$class = new $className($_POST['id']);
	
	if ($class->deleteFromForm()) {
		echo $_POST['href'];
	} else {
		$_SESSION['error'] = "Something went wrong and did not delete.  Please report error with this ID: AFS4875";	
		echo $_POST['href'];
	}	
}




//Change Password
if (isset($_POST['usersPassword'])) {
	global $error;
	
	$usr = new Users($_POST['user_id']);
	
	if ($usr->changePassword($_POST['origPass'], $_POST['newPass'])) {
		$error->addError('Your Password has been changed');
		echo 'forms/user_change_password.php';
	} else {
		echo $error->displayErrors();
	}
	

}


//Report Errors to admin
if (isset($_POST['adminConnect'])) {
		
	if (contactAdmin($_POST)) {
		echo 'forms/report_errors.php';
	}
}


//Close Error Box and Remove Errors From Session
if (isset($_POST['closeError'])) {
	global $error;
	
	$error->clearErrors();
	return true;	
}

//Get errors from Class
if (isset($_POST['errorPlacement'])) {
	global $error;	
	
	if ($error->errorsLoaded()) echo $error->displayErrors();
}

?>


