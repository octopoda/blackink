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

//Set Default Page
if (isset($_POST['defaultId'])) {
	$navid = $_POST['defaultId'];
	
	$nav = new Navigation($navid);
	$nav->setDefault($navid);
	
	echo $_POST['href'];	
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


//Redo Access on Change 
if (isset($_POST['access'])) {
	$className = $_POST['class'];
	$class = new $className($_POST['id']);
	$newAccess = $_POST['access'];
	
	$class->setAccess($newAccess, $_POST['id']);
	
	
	echo $class->accessDropDown($newAccess, $_POST['id']);	
}

//Quick Edit Ajax Control
if (isset($_POST['quickEdit'])) {
	$className = $_POST['class'];
	$class = new $className($_POST['id']);
	
	$class->fillFromForm($_POST);
	$class->$_POST['name'] = $_POST['value'];	
	
	$id = $class->save($class->indirectId());
	
	if ($id != null) echo $_POST['href'];
}

//Delete Control
if (isset($_POST['deleter'])) {
	$className = $_POST['class'];
	$class = new $className($_POST['id']);
	
	if ($class->deleteFromForm()) {
		echo $_POST['href'];
	} else {
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


//Change Parent on Menu Switch
if (isset($_POST['menuChange'])) {
	global $error;
	
	$navigation = new Navigation();
	$navigation->listParents($_POST['menu_id']);
	
	$parent =  $navigation->parentDropDown();
	$position = $navigation->positionDropDown($_POST['menu_id'], 0);
	
	echo json_encode(array (
		"parent" => $parent,
		"position" => $position
	));
		
}

//Change the prent
if (isset($_POST['parentChange'])) {
	$navigation = new Navigation();
	echo $navigation->positionDropDown($_POST['menu_id'], $_POST['parent_id']);
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


