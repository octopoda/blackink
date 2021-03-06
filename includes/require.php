<?php
	require_once($_SERVER['DOCUMENT_ROOT']. "/lib/web_config.php");
	require_once(CLASS_PATH.DS. "database.php");
	require_once(CLASS_PATH.DS."databaseObject.php");
	require_once(CLASS_PATH.DS. "functions.php");

	//Library
	require_once(CLASS_PATH.DS. 'users.php');
	require_once(CLASS_PATH.DS. "errors.php");
	require_once(CLASS_PATH.DS. "navigation.php");
	require_once(CLASS_PATH.DS. "menus.php");
	require_once(CLASS_PATH.DS. "mobiledetect.php");
	require_once(CLASS_PATH.DS. "contactinformation.php");
	require_once(CLASS_PATH.DS. "moduledecoder.php");
	require_once(CLASS_PATH.DS. "installer.php");


	//Admin
	require_once(ADMIN_PATH.DS. 'grid.php');

	// //Mail
	require_once(MAIL_PATH.DS. 'class.phpmailer.php');
	require_once(MAIL_PATH.DS. 'class.smtp.php');

	//Plugins
	require_once(PLUGIN_LIB.DS. "sitedisplay.php");

	//SDK

	$site = new Site();

?>