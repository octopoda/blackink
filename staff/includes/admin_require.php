<?php
	require_once($_SERVER['DOCUMENT_ROOT']. "/lib/web_config.php");
	
	
	require_once(CLASS_PATH.DS. "database.php");
	require_once(CLASS_PATH.DS. "errors.php");
	require_once(CLASS_PATH.DS. "functions.php");
	
	//Library
	require_once(CLASS_PATH.DS. "navigation.php");
	require_once(CLASS_PATH.DS. "menus.php");
	require_once(CLASS_PATH.DS. "content.php");
	
	
	//Admin
	require_once(CLASS_PATH.DS. 'users.php');
	require_once(ADMIN_PATH.DS. 'adminNavigation.php');
	
	//Mail
	require_once(MAIL_PATH.DS. 'class.phpmailer.php');
	require_once(MAIL_PATH.DS. 'class.smtp.php');
	
	
	if (isset($_SESSION['user_id'])) {
		$users = new Users($_SESSION['user_id']);
	} else {
		$users = new Users();	
	}
?>