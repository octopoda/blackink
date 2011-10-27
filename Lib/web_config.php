<?php
    // Modify this for environment
	defined('SERVER') ? null : define('SERVER', "dev");
	global $siteURL;

    if (SERVER == "dev") {
		define("HOSTNAME", "localhost"); 
		define("DB_USER", "root");
		define("DB_PASS", "root");
		define("DB_NAME", "blackink");  
		
		//Site Files
		define('DS', DIRECTORY_SEPARATOR);
		define('SITE_ROOT', DS. 'Applications' .DS. 'MAMP' .DS. 'htdocs' .DS. 'blackink' .DS);
		define('SITE_FILES', $_SERVER['DOCUMENT_ROOT']);
		define('INCLUDES', SITE_FILES.DS.  "includes" .DS);
		define('MODULES', SITE_FILES.DS.  "modules" .DS);
		define('CSS', SITE_FILES.DS. 'css' .DS);
		define('CLASS_PATH', SITE_FILES.DS. 'lib');
		define('ADMIN_PATH', CLASS_PATH.DS. 'admin');
		define('MAIL_PATH', CLASS_PATH.DS. 'mailer');
		
		//SMTP
		define('EMAIL_HOST', 'mail.2721west.com');
		define('EMAIL_USER', 'zack@2721west.com');
		define('EMAIL_PASS', '!@34QWermail');
		define('EMAIL_PORT', 26);
	
		define("REPORT_USER", 'zack@2721west.com');
		define("REPORT_PASS", '!@34QWermail');
	
	
	
	}else if (SERVER == "live") {
		//Database
       define("DB_SERVER", ""); 
		define("DB_USER", "");
		define("DB_PASS", "");
		define("DB_NAME", "");
		
		//Site Files
		define('DS', DIRECTORY_SEPARATOR);
		define('SITE_ROOT', DS.'home1');
		define('SITE_FILES', $_SERVER['DOCUMENT_ROOT'] .DS);
		define('INCLUDES', SITE_FILES."includes" .DS);
		define('MODULES', SITE_FILES."modules" .DS);
		define('LIB_PATH', SITE_FILES.'includes');
		define('CLASS_PATH', LIB_PATH.DS. 'class');
		define('MAIL_PATH', LIB_PATH.DS. 'mailer');
		
		//SMTP
		define('HOST', "");
		define('EMAIL_USER', "");
		define('EMAIL_PASS', "");
		define('EMAIL_PORT', 26);
		
		define("REPORT_USER", '');
		define("REPORT_PASS", '');
	} 
?>
