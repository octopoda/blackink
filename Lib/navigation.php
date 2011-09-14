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
		
		//Helpers
		public $navigationList;
		public $subNavList;
		
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
		function listNav($menu_id) {
			global $db;
			global $error;
			
			$sql = "SELECT N.title, N.position, N.access, N.published, N.navigation_id, N.parent FROM menus M 
						JOIN navigationForMenus NM ON M.menu_id = NM.menu_id
						JOIN navigation N ON NM.navigation_id = N.navigation_id
						WHERE M.menu_id = {$menu_id} AND N.parent = 0 ORDER BY position";
			
			$result_set = $db->queryFill($sql);
			if ($result_set != false) {
				if (count($result_set) == 1) $result_set = array_shift($result_set);
				
				//Get navigation 
				foreach($result_set as $row) {
					$navigation = new Navigation($row['navigation_id']);
					$this->itemList[] = $navigation;
				}
				
				//Get the Subnav and place them in itemList
				for ($i = 0; $i < count($this->itemList); $i++) {
					$subNav = $db->queryFill("SELECT title, position, access, published, parent, navigation_id FROM navigation WHERE parent = " . $this->itemList[$i]->navigation_id. " ORDER BY position");
					
					foreach ($subNav as $nav) {
						$sub = new Navigation($nav['navigation_id']);
						$this->itemList[$i]->subNavList[] = $sub;	
					}	
					
				}
				
				
				
			} else {
				$error->addError("There are no navigation items in your menu");
				return false;
			}
			
		}
	
	
	}
	
	
	
?>
