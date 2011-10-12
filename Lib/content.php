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
		$content_id = $this->save($this->content_id);
		 
		if (isset($content_id)) {
			
		} else {
			$error->addError('The information did not save.  Please report the error id: #Content1284');	
		}
	}
	
	
	
	//Delete
	public function deleteFromForm() {
		global $error;
			
			if ($this->delete($this->content_id)) {
				return true;
			} else {
				$error->addError('the information did not save.  Please report the error id: #Content1564');	
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
