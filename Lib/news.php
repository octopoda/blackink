<?php
   	require_once("databaseObject.php");
	
    class News extends databaseObject{
        
        public $table = "news";
        public $idfield = "news_id";
        
        public $news_id;
		public $content;
		public $published;
		public $created_on; 
		public $title; 
		public $access;
		public $user_id;
		
		//Helper Functions
		public $newsList;
		
        public function __construct($n_id="") {
           if (empty($n_id)) $n_id = $this->news_id;
			
			if (!empty($n_id)) {
         		$result = $this->fetchById($n_id); 
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
	public function createNewsFromForm($post) {
		global $error;
		
		$this->fillFromForm($post);
		
		
		
		$news_id = $this->save($this->news_id);
		 
		if (isset($news_id)) {
			return true;
		} else {
			$error->addError('The information did not save.  Please report the error id: #News1284');	
		}
	}
	
	
	
	//Delete
	public function deleteFromForm() {
		global $error;
			
		if ($this->delete($this->news_id)) {
			return true;
		} else {
			$error->addError('the information did not save.  Please report the error id: #News1564');	
		}
	}
	
	
/* ========================================
	Redefine Methods 
	==================================== */
	
}// /Class
?>
