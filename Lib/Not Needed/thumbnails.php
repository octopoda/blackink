<?php
    require_once("databaseObject.php");
	
    class Thumbnails extends databaseObject{
        
        public $table = "thumbnails";
        public $idfield = "thumbnail_id";
        
		public $thumbnail_id;
        public $file_name;
		public $alt_name;
		
		//helpers
		public $filepath = '/images/thumbnails/';
		 
		
        public function __construct($t_id="") {
			if (empty($t_id)) $t_id = $this->thumbnail_id;
			$this->fetchById($t_id);
		}
		
		public function thumbnailImage($t_id="") {
			if (empty($t_id)) $t_id = $this->thumbnail_id;
			
			$html = '<img src="'. $this->filepath .$this->file_name . '" alt="'.$this->alt_name.'" />';
					
			return $html;
		}
		
		public function changeThumbnail($p_id="") {
			global $db;
			
			if (empty($t_id)) $t_id = $this->thumbnail_id;
			
			$result = $db->queryFill("SELECT * FROM thumbnailsInProject WHERE project_id = {$p_id} LIMIT 1");
			$result = array_shift($result);
			
			if ($result != false) {
				$db->query("UPDATE thumbnailsInProject SET thumbnail_id = {$this->thumbnail_id} WHERE thumbnail_id = {$result['thumbnail_id']}");		
			}
			
		}
    
	}
?>
