<?php
    // Modify this for environment
	defined('SERVER') ? null : define('SERVER', "dev");
	global $siteURL;

    if (SERVER == "dev") {
		define("HOSTNAME", "localhost");
		define("DB_USER", "root");
		define("DB_PASS", "V8Juice");
		define("DB_NAME", "testing");

		//Site Files
		define('DS', DIRECTORY_SEPARATOR);
		define('SITE_ROOT', DS. 'Applications' .DS. 'MAMP' .DS. 'htdocs' .DS. 'blackink' .DS);
		define('SITE_FILES', $_SERVER['DOCUMENT_ROOT']);
		define('INCLUDES', SITE_FILES.DS.  "includes" .DS);
		define('MODULES', SITE_FILES.DS.  "modules" .DS);
		define('CSS', SITE_FILES.DS. 'css' .DS);
		define('CLASS_PATH', SITE_FILES.DS. 'lib');
		define('SCRIPTS_PATH', SITE_FILES.DS. 'js');
		define('ADMIN_PATH', CLASS_PATH.DS. 'admin');
		define('FILE_PATH', SITE_FILES.DS."files".DS."uploads");
		define('MAIL_PATH', CLASS_PATH.DS. 'mailer');
		define('PLUGIN_PATH', SITE_FILES.DS. 'plugins');
		define('PLUGIN_LIB', PLUGIN_PATH.DS. 'lib');
		define('PLUGIN_AJAX', PLUGIN_PATH.DS. 'ajax');

		//SMTP
		define('EMAIL_HOST', 'host300.hostmonster.com');
		define('EMAIL_USER', 'zack@2721west.com');
		define('EMAIL_PASS', '!@34QWermail');
		define('EMAIL_PORT', '26');

		define("REPORT_USER", 'zack@2721west.com');
		define("REPORT_PASS", '!@34QWermail');



	}else if (SERVER == "live") {
		//Database
       	define("HOSTNAME", "localhost");
		define("DB_USER", "twosevtw_phuzion");
		define("DB_PASS", "!Q2w#E4r%T6y");
		define("DB_NAME", "twosevtw_2721");

		//Site Files
		define('DS', DIRECTORY_SEPARATOR);
		define('SITE_ROOT', DS. 'Applications' .DS. 'MAMP' .DS. 'htdocs' .DS. 'blackink' .DS);
		define('SITE_FILES', $_SERVER['DOCUMENT_ROOT']);
		define('INCLUDES', SITE_FILES.DS.  "includes" .DS);
		define('MODULES', SITE_FILES.DS.  "modules" .DS);
		define('CSS', SITE_FILES.DS. 'css' .DS);
		define('CLASS_PATH', SITE_FILES.DS. 'lib');
		define('ADMIN_PATH', CLASS_PATH.DS. 'admin');
		define('FILE_PATH', SITE_FILES.DS."files".DS."uploads");
		define('MAIL_PATH', CLASS_PATH.DS. 'mailer');
		define('PLUGIN_PATH', SITE_FILES.DS. 'plugins');
		define('PLUGIN_LIB', PLUGIN_PATH.DS. 'lib');
		define('PLUGIN_AJAX', PLUGIN_PATH.DS. 'ajax');

		//SMTP
		define('EMAIL_HOST', 'host300.hostmonster.com');
		define('EMAIL_USER', 'zack@2721west.com');
		define('EMAIL_PASS', '!@34QWermail');
		define('EMAIL_PORT', '26');

		define("REPORT_USER", 'zack@2721west.com');
		define("REPORT_PASS", '!@34QWermail');
	}
?>
