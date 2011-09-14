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
		
		 public function __construct($n_id="") {
			 if (empty($n_id)) $n_id = $this->navigation_id;
			
			if (!empty($n_id)) {
         		$result = $this->fetchById($n_id); 
			} 
		}
		
		
		//Create Main Navigation
		
		//Create Dropdowns
		
		//Attach Navigation to Content
		
		//Display Navigtion 	
	
/*  ===========================================
	Admin Methods
	========================================= */	
	
		//List Navigation for Menus
		function listNav($menu) {
				
		}
	
	
	}
	
	
	
?>
