<?php 
	
	
	//Autoload Function 
	function __autoload($class_name) {
		$class_name = strtolower($class_name);
		$path = CLASS_PATH.DS. $class_name.".php";

		if (file_exists($path)) {
			require_once($path);	
		} else {
			die("The file {$class_name}.php could not be found");	
		}
	}
	
	function redirect($location) {
		printf("<script>window.location ='{$location}'</script>");
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
	
	
	
	function getTitle($pageTitle) {
		
		switch ($pageTitle) {
					case 'About Cadence':
						echo "About Cadence General Contracting Services LLC.";
						break;
					case 'current':
						echo "Current Contractor Project";
						break;
					case 'complete':
						$html = "Cadence's Complete Projects "; 
						if (!empty($pageTitle)) $html.= " :: " . $pageTitle . ' Project';
						echo $html;
						break;
					case 'Testimonials':
						echo "Our top testimonials";
						break;
					case 'Our Services':
						echo "Our General Contracting Services";
						break;
					case 'Our Process':
						echo "Cadence Step by Step Processes";
						break;
					case 'Contact Cadence':
						echo "Contact Cadence";
						break;
					default:
						echo "General Contractor for Coppell, Southlake, Colleyville, Keller, Texas";
						break;	
				}	
		
	}
	
	function scriptIncludes () {
		$html = '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>';
        $html .= '<script type="text/javascript" src="../scripts/validation.js"></script>';
        $html .= '<script type="text/javascript" src="../scripts/ckeditor/ckeditor.js"></script>';
		$html .= '<script type="text/javascript" src="../scripts/ckeditor/adapters/jquery.js"></script>'; 
		$html .= '<script type="text/javascript" src="../ckfinder/ckfinder.js"></script>';
		$html .= '<script type="text/javascript" src="../scripts/ajaxupload.js"></script>';
		$html .= '<script type="text/javascript" src="../scripts/slideshow.min.js"></script>';
		$html .= '<script type="text/javascript" src="../scripts/admin_functions.js"></script>';
		
		return $html;
	}
	
	
		
	
	
?>
	

