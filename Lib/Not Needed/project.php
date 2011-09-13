<?php
   require_once("databaseObject.php");
   require_once("projectView.php");
   require_once("projectImages.php");
	
   class Project extends databaseObject{
        
        public $table = "project";
        public $idfield = "project_id";
        
       	public $project_id;
		public $objective;
		public $active;
		public $projectTitle;
		public $testimonial;
		public $featured;
		public $names;
		
		
		//Helpers
  		public $linkedTitle;
		public $projectView;
		public $position;
		public $imageList;
		public $projectLink;
		
		
        public function __construct($p_id="") {
         	if (empty($p_id)) $p_id = $this->project_id;
			
			$this->fetchById($p_id);
			$this->linkedTitle = $this->setupProjectLink();
			
			if ($p_id != false) {
				$this->projectView = new ProjectView($p_id);
				$this->position = $this->projectView->position;
				$this->setUpImages();
				$this->projectLink = $this->projectLink();
			}
		}
		
		//Setup Project link
		private function projectLink() {
			$catLink = str_replace(" ", "_", $this->projectView->category_name);
			return '/projects/'. $catLink .'/'. $this->linkedTitle. '.php';	
		}
		
		//Setup link for Website Viewing
    	private function setupProjectLink() {
			return urlencode(str_replace(" " , "_", $this->projectTitle));
		}
		
		//Deciper Link on get statement
		public static function decipherLinkedTitle($linkedTitle) {
			return urldecode(str_replace("_", " ", $linkedTitle));
		}	
		
		public function getProjectLink() {
			$this->projectLink = '/projects/'.$this->projectView->category_name .'/'. $this->linkedTitle. '.php';
		}
		
		//Get the id of project for title name
		public static function getIdFromTitle($projectTitle) {
			global $db;
			global $error;
			
			$result = $db->queryFill("SELECT * FROM project WHERE projectTitle = '{$projectTitle}' LIMIT 1");
			
			if ($result != false) {
				$result = array_shift($result);
				return $result['project_id'];	
			}else 
				$error->addError("There is no project for this Title");
		}
			
		
		//Setup Images
		private function setupImages() {
			global $db;
			
			$result = $db->queryFill("SELECT * FROM vw_images WHERE project_id = {$this->project_id} ORDER BY position");
			
			if ($result != false) {
				if (count($result) == 1) {
					$result = array_shift($result);
					$image = new ProjectImages($result['image_id']);
					$this->imageList[] = $image;				
				}else {
					foreach ($result as $img) {
						$image = new ProjectImages($img['image_id']);
						$this->imageList[] = $image;
					}
				}
			}
		}
		
		//Place project in New Cateogry
		public function placeProjectInCategory($p_id, $c_id) {
			global $db;	
			
			
			$result = $db->queryFill("SELECT * FROM projectInCategory WHERE project_id = {$p_id} LIMIT 1");
			$result = array_shift($result);
			
			if ($result != false) {
				if ($result['category_id'] != $c_id) {
					$g_id = $this->bottomPosition($c_id) + 1;
					$db->query("UPDATE projectInCategory SET category_id = {$c_id}, position = {$g_id} WHERE project_id = {$p_id}");
				} else {
						
				}
			} else {
				$this->projectView->category_id = $c_id;
				$position = $this->bottomPosition() +1;
				
				
				$this->setupThumbnail();
				$db->query("INSERT INTO projectInCategory (project_id, category_id, position ) VALUES ({$p_id}, {$c_id}, {$position})");
			}
			
			return ($db->affectedRows() > 0);
		}
		
		//Setup Thumbnail For Project
		public function setupThumbnail() {
			global $db;
			
			$db->query("INSERT INTO thumbnailsInProject (thumbnail_id, project_id) VALUES (1, {$this->project_id})");
			return ($db->affectedRows() > 0);	
		}
		
		//Feature a Project
		public function featureProject() {
			global $db;
			global $error;
			
			$db->query("UPDATE project SET featured = 0");
			
			if ($db->affectedRows() > 0) {
				$db->query("UPDATE project SET featured = 1 WHERE project_id = {$this->project_id}");
				return ($db->affectedRows() > 0);	
			} else {
				$error->addError("Something went wrong please report Error with ID: PR45895");	
			}
			
			
		}
		
		//Return Featured Project
		public static function getFeaturedProject() {
			
			global $db;
			global $error;
			
			$result = $db->queryFill("SELECT * FROM project WHERE featured = 1 LIMIT 1");
			if ($result != false) {
				$result = array_shift($result);
				return $result['project_id'];	
			}
		}
		
		//Change Position since dynamic File and not flat file.
		public function setPosition ($newPosition, $varName) {
			global $db; 
			
			$result  =  
			
			$position = $varName;
			
			$posLow = $position;
			$posHigh = $newPosition;
			
			if ($posLow > $posHigh) {
				$posLow = $newPosition;
				$posHigh = $position;
			}
			
			$db->query("UPDATE projectInCategory SET position = 4000 WHERE position = {$position} AND category_id = {$this->projectView->category_id}");
			$db->query("SELECT @sign:= SIGN({$position}-{$newPosition}) FROM projectInCategory WHERE category_id = {$this->projectView->category_id}");
			$db->query("UPDATE projectInCategory SET position = @sign + position WHERE position BETWEEN {$posLow} AND {$posHigh} AND category_id = {$this->projectView->category_id}");
			$db->query("UPDATE projectInCategory SET position = {$newPosition} WHERE position = 4000 AND category_id = {$this->projectView->category_id}");
			
			if ($db->affectedRows() > 0) {
			
			}
		}	
		
		//Change Position since dynamic File and not flat file.
		public function topPosition() {
			global $db;
			
			$result = $db->queryFill("SELECT * FROM projectInCategory WHERE category_id = {$this->projectView->category_id} ORDER BY position ASC LIMIT 1");
			$result = array_shift($result);
			
			return $result['position'];
		}
		
		//Change Position since dynamic File and not flat file.
		public function bottomPosition($catId = "") {
			global $db;
			
			if (empty($catId)) $catId = $this->projectView->category_id;
			
			$result = $db->queryFill("SELECT * FROM projectInCategory WHERE category_id = {$catId} ORDER BY position DESC LIMIT 1");
			$result = array_shift($result);
			
			return 	$result['position'];
			
		} 
		
		
		//Delete the project
		public function deleteFromForm() {
			global $db;
			
			$db->query("DELETE FROM projectInCategory WHERE project_id = {$this->project_id}");
			$db->query("DELETE FROM thumbnailsInProject WHERE project_id = {$this->project_id}");
			$db->query("DELETE FROM imagesForProject WHERE project_id = {$this->project_id}");
			$db->query("DELETE FROM project WHERE project_id = {$this->project_id}");
			
			return ($db->affectedRows() > 0);
				
		}
		
		
	}
?>
