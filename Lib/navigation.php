<?php
	require_once('databaseObject.php');
	
	
    class Navigation extends databaseObject {
      	public $table = "navigation";
        public $idfield = "navigation_id";
		
		public $navigation_id;
		public $title;
		public $parent;
		public $access;
		public $position;
		public $published;
		public $link;
		
		 public function __construct($navigation_id="") {
			 
		 }
		
		//Create Main Navigation
		
		//Create Dropdowns
		
		//Attach Navigation to Content
		
		//Display Navigtion 	
	}
?>
