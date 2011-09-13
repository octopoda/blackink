<?php
   	require_once("databaseObject.php");
	
    class News extends databaseObject{
        
        public $table = "news";
        public $idfield = "news_id";
        
        public $news_id;
		public $content;
		public $published;
		public $user_created;
		public $created_on;
		public $position;
		public $title;
		public $access;
		
        public function __construct($p_id="") {
           
        }
		
		
		
		
		
	}
?>
