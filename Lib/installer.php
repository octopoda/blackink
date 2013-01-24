<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');

	class Installer {
		private $endComment = '//End Comments';

	//Front End
		//Move the file to plug in folder
		public function moveToPlugin($source) {
			$files = scandir($source);
			$destination = $_SERVER['DOCUMENT_ROOT']."/plugins/lib/";

			$this->moveFiles($source, $destination, $files);

		}

		//Add appropriate scripts to the scripts page with comments
		public function addToScript($code) {
			$script = SCRIPTS_PATH.DS. 'extra_script.js';
			return $this->setScripts($code, $script);
		}

		public function moveToJSLib($source) {
			$files = scandir($source);
			$destination = $_SERVER['DOCUMENT_ROOT'].'/js/libs/';

			$this->moveFiles($source, $destination, $files);
		}

		public function moveToAdminCSS($source) {
			$files = scandir($source);
			$destination = $_SERVER['DOCUMENT_ROOT'].'/staff/css/';

			$this->moveFiles($source, $destination, $files);
		}

		//Add ajax to plugin ajax page.
		public function addToPlugin($code) {
			$pluginPage = PLUGIN_AJAX.DS. 'plugin_site_submit.php';
			return $this->setFiles($code, $pluginPage);
		}

		public function moveToRoot($source) {
			$files = scandir($source);
			$destination = $_SERVER['DOCUMENT_ROOT'].DS;

			$this->moveFiles($source, $destination, $files);

		}






	//Back End

		//Run SQL Code
		public function runSQL($sql) {
			global $db;

			$db->query($sql);
		}

		//Build Admin Navigation
		public function adminNavigation($parent, $childArray) {
			global $db;

			//Get the high position.
			$result_set = $db->queryFill("SELECT position FROM adminNavigation WHERE position < 20 ORDER BY position DESC limit 1  ");
			$result_set = array_shift($result_set);
			$pos = $result_set['position']+1;

			$sql = "INSERT INTO adminNavigation (title, link, access, position, published, parent_id )  VALUES ";
			foreach ($parent as  $title=>$link) {
				$sql .= " ('{$title}', '{$link}', 3, '{$pos}', '1', '0')";
			}
			//echo $sql. '<p></p>';
			$db->query($sql);
			$id = $db->insertedID();

			$sql = "INSERT INTO adminNavigation (title, link, access, position, published, parent_id )  VALUES ";

			$nTimes = 0;
			$length = count($childArray);

			foreach ($childArray as $title=>$link) {
				$sql .= " ('{$title}', '{$link}', 3, '{$nTimes}', '1', '{$id}')";
				if ($nTimes+1 != $length) {
					$sql .= ', ';
				}
				$nTimes++;
			}

			//echo $sql;
			$db->query($sql);
		}

		// Add folder to forms
		public function moveStaffFolder($source, $folder_name) {
			$files = scandir($source);
		    $destination = $_SERVER['DOCUMENT_ROOT']."/staff/forms/".$folder_name.DS;
		    mkdir($destination);

		    $this->moveFiles($source, $destination, $files);

		}

		// Add Ajax to plug in file
		public function addStaffPlugins($code) {
			$pluginPage = PLUGIN_AJAX.DS. 'plugin_form_submit.php';
			return $this->setFiles($code, $pluginPage);
		}

		// add script to js file
		public function addStaffScript($code) {

		}

		//Add to Grid
		public function addGrid($code) {
			$pluginPage = PLUGIN_AJAX.DS. 'plugin_grid.php';
			return $this->setFiles($code, $pluginPage);
		}

		//Add to Site Display
		public function addSiteDisplay($code) {
			$pluginPage = PLUGIN_LIB.DS. 'sitedisplay.php';
			return $this->setClass($code, $pluginPage);
		}


	//Needed Methods
		//Move all files in a folder
		private function moveFiles($source, $destination, $files) {
			$delete = array();

			foreach ($files as $file) {
		      	if (in_array($file, array(".",".."))) continue;
		      	if (copy($source.$file, $destination.$file)) {
		        	$delete[] = $source.$file;
		      	}
		    }
		    foreach ($delete as $file) {
		     	unlink($file);
		    }
		}

		//Write to up plugin files
		private function  setFiles($code, $file) {
			$content = file_get_contents($file);
			$content = $this->parseFiles($content, $code);
			if ($content != false) file_put_contents($file, $content);
			return true;
		}

		//Write to a class files
		private function  setClass($code, $file) {
			$content = file_get_contents($file);
			$content = $this->parseClasses($content, $code);
			if ($content != false) file_put_contents($file, $content);
			return true;
		}

		//Write to script files
		private function setScripts($code, $file) {
			$content = file_get_contents($file);
			$content = $this->parseScripts($content, $code);
			if ($content != false) file_put_contents($file, $content);
			return true;
		}

		//Parse plugin files
		private function  parseFiles($file_contents, $code) {
			$commentPos = strpos($file_contents, $this->endComment);
			$content = '';

			if ($commentPos === false) {
				$phpString = strpos($file_contents, '<?php');
				$content .= '<?php';
				$content .= $code;
				$content .= $this->endComment;
				$content .= '?>';
			} else {
				$sub = substr($file_contents, 1, $commentPos-1);
				$content .= '<'.$sub;
				$content .= $code;
				$content .= $this->endComment;
				$content .= '?>';
			}

			return $content;
		}

		//Parse Classes files
		private function  parseClasses($file_contents, $code) {
			$commentPos = strpos($file_contents, $this->endComment);
			$content = '';

			if ($commentPos === false) {
				$phpString = strpos($file_contents, '<?php');
				$content .= '<?php';
				$content .= $code;
				$content .= $this->endComment . "

				 } ?>";

			} else {
				$sub = substr($file_contents, 1, $commentPos-1);
				$content .= '<'.$sub;
				$content .= $code;
				$content .= $this->endComment . "

				 } ?>";

			}

			return $content;
		}

		//Parse Scripts Files
		private function  parseScripts($file_contents, $code) {
			$commentPos = strpos($file_contents, $this->endComment);
			$content = '';

			if ($commentPos === false) {
				$content .= '$(document).ready(function () {';
				$content .= $code;
				$content .= $this->endComment;
				$content .= '});';
			} else {
				$sub = substr($file_contents, 1, $commentPos-1);
				$content .= '$'.$sub;
				$content .= $code;
				$content .= $this->endComment;
				$content .= '});';
			}
			return $content;
		}


} //end class


?>