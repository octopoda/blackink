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
		public $summary;
		
		//Helper Functions
		public $newsList;
		public $directLink;
		
        public function __construct($n_id="") {
           if (empty($n_id)) $n_id = $this->news_id;
			
			if (!empty($n_id)) {
         		$result = $this->fetchById($n_id); 
				$this->directLink = $this->createLink('news', $this->title);
			} 
        }
/* ========================================
	Build/Helper Methods 
	==================================== */	 
		public function listNews($limit="") {
			global $db;
			
			$sql = "SELECT * FROM news ORDER BY created_on DESC";
			
			if (!empty($limit)) {
				$sql .= " LIMIT {$limit}"; 
			}
			
			$result_set = $db->queryFill($sql);
			
			if ($result_set != false) {
				foreach ($result_set as $row) {
					$this->newsList[]	= new News($row['news_id']);
				}
			}
		}
		
		
				
		
/* ========================================
	Display Methods 
	==================================== */
		
	static function newsIdFromTitle($title) {
		global $db;
		
		$result_set = $db->queryFill("SELECT news_id FROM news WHERE title = '{$title}'");
		
		if ($result_set != false) {
			foreach ($result_set as $row) {
				return $row['news_id'];	
			}
		}
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
			$error->addError('The information did not save.', 'News1284');	
		}
	}
	
	
	
	//Delete
	public function deleteFromForm() {
		global $error;
			
		if ($this->delete($this->news_id)) {
			return true;
		} else {
			$error->addError('the information did not save.' ,'News1564');	
		}
	}
	
	
/* ========================================
	Redefine Methods 
	==================================== */
	
}// /Class
?>
