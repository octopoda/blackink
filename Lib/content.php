<?php
   	require_once("databaseObject.php");
	
    class Content extends databaseObject{
        
        public $table = "content";
        public $idfield = "content_id";
        
        public $content_id;
		public $user_id;
		public $created_on;
		public $published;
		public $modified_on;
		public $title;
		public $access;
		public $content;
		public $link_to;
		public $modified_by;
		public $searchable;
		
		//Helper Functions
		public $objectList;
		
        public function __construct($c_id="") {
           if (empty($c_id)) $c_id = $this->content_id;
			
			if (!empty($c_id)) {
         		$result = $this->fetchById($c_id); 
			} 
        }
/* ========================================
	Build/Helper Methods 
	==================================== */	 
	
	static function contentFromTitle($title) {
		global $db;
		global $error;
		
		$result = $db->queryFill("SELECT content_id FROM content WHERE title = '{$title}'");
		
		if ($result != false) {
			foreach ($result as $row) {
				return $row['content_id'];	
			}
		} else {
			return false;	
		}
	}
	
	
	
		
		
/* ========================================
	Display Methods 
	==================================== */
		
	public function searchContent($searchQuery) {
				
	}	
		
/* ========================================
	Admin Methods 
	==================================== */
	
	//CRU
	public function createContentFromForm($post) {
		global $error;
		
		$this->fillFromForm($post);
		
		if ($this->content_id == NULL) {
			$this->created_on = $this->setCreateDate();
		}
		
		if ($this->user_id == NULL) {
			$this->user_id = $this->modified_by; 	
		}
		
		$this->modified_on = date("Y-m-d h:i:s");
		$this->searchable = strip_tags($_POST['content']);
		
		$content_id = $this->save($this->content_id);
		 
		if (isset($content_id)) {
			
		} else {
			$error->addError('The information did not save.', 'Content1284');	
		}
	}
	
	
	
	//Delete
	public function deleteFromForm() {
		global $error;
			
			if ($this->delete($this->content_id)) {
				return true;
			} else {
				$error->addError('The information did not save.', 'Content1564');	
			}
	}
	
	//Set Create Date 
	private function setCreateDate() {
		 return date("Y-m-d h:i:s");
	}

/* ========================================
	Redefine Methods 
	==================================== */
	
}// /Class
?>
