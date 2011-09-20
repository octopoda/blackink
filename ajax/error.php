<?php

require_once('../includes/require.php');

if (isset($_POST['error'])) {
	global $error;
	
	$error->addError("Something has gone wrong with out system. Please contact our admin.", $_POST['error']);
	return true;	
}


if (isset($_POST['display'])) {
	global $error;
	
	if ($error->errorsLoaded()) {
		echo $error->displayErrors();
	}
	return;
}



?>