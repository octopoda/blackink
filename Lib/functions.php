<?php


	//Auto-load Classes
	function __autoload($class_name) {
		$class_name = strtolower($class_name);
		$path = CLASS_PATH.DS. $class_name.".php";
		$plugin = PLUGIN_LIB.DS. $class_name.".php";
		$mail = MAIL_PATH.DS.$class_name.".php";
		$admin = ADMIN_PATH.DS.$class_name.".php";

		if (file_exists($path)) {
			require_once($path);
		} else if (file_exists($plugin)){
			require_once($plugin);
		} else if (file_exists($mail)){
			require_once($mail);
		} else if (file_exists($admin)){
			require_once($admin);
		}else {
			die("The file {$class_name}.php could not be found");
		}
	}

	function redirect($location) {
		printf("<script>window.location ='%s'</script>", $location);
		exit;
	}

	function curPageURL() {
		 global $pageURL;
		 global $pageTitle;
		 global $folder;

		 $pageURL = 'http://';
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }

		 $folder = $pageURL;
		 $positionFolder = strpos($pageURL, "/" , 7) +1 ;
		 $lengthFolder = strlen($pageURL) - $positionFolder;
		 $folder = substr($pageURL, $positionFolder, 8);

		 $position = strrpos($pageURL, "/") + 1;
		 $length = strlen($pageURL) - $position;
		 $pageURL = substr($pageURL, $position, $length);

		 $pageTitle = str_replace(".", " ", $pageURL);

		 $position2 = strrpos($pageTitle, " ");
		 $length2 = strlen($pageTitle);

		 $pageTitle = substr($pageTitle, -($length2), $position2);

		 $pageTitle = str_replace("_", " ", $pageTitle);
		 $words = explode(" ", $pageTitle);

		 foreach($words as $word) {
			$word = ucfirst($word);
			$newTitle[] = $word;
		}

		$pageTitle = implode(" ", $newTitle);



		 return $pageURL;
		 return $pageTitle;
		 return $folder;

	}


	function truncate($string, $limit, $break=".", $pad="...") {
		if(strlen($string) <= $limit) return $string;

		if(false !== ($breakpoint = strpos($string, $break, $limit))) {
			if($breakpoint < strlen($string) - 1) {
				$string = substr($string, 0, $breakpoint) . $pad;
			}
		}

		return $string;
	}








?>


