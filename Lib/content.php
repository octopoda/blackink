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
		public $modified_by;
		public $searchable;
		public $summary;
		
		//Helper Functions
		public $objectList;
		public $directLink;
		
        public function __construct($c_id="") {
           if (empty($c_id)) $c_id = $this->content_id;
			
			if (!empty($c_id)) {
         		$result = $this->fetchById($c_id);
				$this->getLink();
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
	
	private function getLink() {
		$title = str_replace(" ", "_", $this->title);
		$this->directLink = '/content/'	.urlencode($title).'.html';
	}
	
	
	
		
		
/* ========================================
	Display Methods 
	==================================== */
		
	static public function searchContent($searchTerm, $limit = null) {
		global $db;
		
		if (empty($limit)) {
			$sql = "SELECT * FROM content WHERE searchable LIKE '%{$searchTerm}%' OR title LIKE '%{$searchTerm}%'";	
		} else {
			$sql = "SELECT * FROM content WHERE searchable LIKE '%{$searchTerm}%' OR title LIKE '%{$searchTerm}%'" . $limit;
		}
		
		$result_set = $db->queryFill($sql);	
		return $result_set;
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
		$this->summary = strip_tags($_POST['summary']);
		
		$content_id = $this->save($this->content_id);
		
		if (!empty($content_id)) {
			return $content_id;
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
