<?php
	require_once($_SERVER['DOCUMENT_ROOT']. "/lib/web_config.php");
	require_once(CLASS_PATH.DS. "database.php");
	require_once(CLASS_PATH.DS. "errors.php");
	require_once(CLASS_PATH.DS. "functions.php");
	
	require_once(CLASS_PATH.DS. "content.php");
	
	require_once(CLASS_PATH.DS. 'users.php');
	require_once(ADMIN_PATH.DS. 'admin_navigation.php');
	
	if ($error->errorsLoaded()) echo $error->displayErrors();

?>