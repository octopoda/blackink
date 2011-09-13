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
		
		//Helper Functions
		public $objectList;
		
        public function __construct($c_id="") {
           if (empty($c_id)) $c_id = $this->content_id;
			
			if (!empty($c_id)) {
         		$result = $this->fetchById($c_id); 
			} 
        }
		 
		
		public function searchContent($searchQuery) {
				
		}
	}
?>
