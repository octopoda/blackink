<?php
  	require_once("databaseObject.php");
	
    class ProjectImages extends databaseObject{
        
        public $table = "projectImages";
        public $idfield = "image_id";
        
        public $image_id;
		public $image_alt;
		public $file_name;
		
		//Helpers
		public $position;
		public $filePath = "/images/projects/";
		public $project_id;
  
        public function __construct($i_id="") {
           if (empty($i_id)) $i_id = $this->image_id;
		   $this->fetchById($i_id);
		   
		   if (isset($i_id)) {
		   		$this->projectForImage();
		   }
        }
		
		public function printImage($i_id="", $width) {
			if (empty($i_id)) $i_id = $this->image_id;
			return '<img src="'.$this->filePath. $this->file_name .'" alt="'. $this->image_alt .'" width="'.$width.'" />';
		}
		
		private function projectForImage() {
			global $db;
			
			$result = $db->queryFill("SELECT project_id, position FROM imagesForProject WHERE image_id = {$this->image_id} LIMIT 1");
			
			if ($result != false) {
				
				foreach($result as $id) {
					$this->project_id = $id['project_id'];
					$this->position = $id['position'];	
				}
			}
		}
		
		
		public function fillUploadImage($post, $fileName) {
			$this->file_name = $fileName;
			$this->project_id = $post['id'];
			$this->image_alt = $post['title'] . ' image';
			
			return $this->save();
		}
		
		public function connectImageToProject($i_id, $p_id) {
			global $db;
			
			$this->position = $this->bottomPosition() + 1;
			
			$db->query("INSERT INTO imagesForProject (image_id, project_id, position) VALUES ({$i_id}, {$p_id}, {$this->position})");
			
			return ($db->affectedRows() > 0);	
		}
		
		public function deleteImageFromProject($i_id) {
			global $db;
			
			$this->setPosition($this->bottomPosition(), $this->position);
			
			$db->query("DELETE FROM imagesForProject WHERE image_id = {$i_id}");
			$db->query("DELETE FROM projectImages WHERE image_id = {$i_id}");
			
			return ($db->affectedRows() > 0);	
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
			
			
			$db->query("UPDATE imagesForProject SET position = 4000 WHERE position = {$position} AND project_id = {$this->project_id}");
			$db->query("SELECT @sign:= SIGN({$position}-{$newPosition}) FROM projectInCategory WHERE project_id = {$this->project_id}");
			$db->query("UPDATE imagesForProject SET position = @sign + position WHERE position BETWEEN {$posLow} AND {$posHigh} AND project_id = {$this->project_id}");
			$db->query("UPDATE imagesForProject SET position = {$newPosition} WHERE position = 4000 AND project_id = {$this->project_id}");
			
			return ($db->affectedRows() > 0);
		}	
		
		//Change Position since dynamic File and not flat file.
		public function topPosition() {
			global $db;
			
			$result = $db->queryFill("SELECT * FROM imagesForProject WHERE project_id = {$this->project_id} ORDER BY position ASC LIMIT 1");
			$result = array_shift($result);
			
			return $result['position'];
		}
		
		//Change Position since dynamic File and not flat file.
		public function bottomPosition() {
			global $db;
			
			$result = $db->queryFill("SELECT * FROM imagesForProject WHERE project_id = {$this->project_id} ORDER BY position DESC LIMIT 1");
			$result = array_shift($result);
			
			return $result['position'];
		} 
		
	}
?>
