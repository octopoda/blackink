<?php
	require_once('databaseObject.php');
	
    class Menus extends databaseObject {
      	public $table = "menus";
        public $idfield = "menu_id";
		
		public $menu_id;
		public $menu_name;
		public $published;
		public $access;
		
		//Helpers
		public $menuList = array();
		
		 public function __construct($m_id="") {
			 if (empty($m_id)) $m_id = $this->menu_id;
			
			if (!empty($m_id)) {
         		$result = $this->fetchById($m_id);
         	} 
		}
		
		public function listMenus() {
			global $db;
			global $error;
			
			$result_set = $db->queryFill("SELECT * FROM menus");
			
			if ($result_set != false) {
				$result_set = $this->arrayShift($result_set);
				foreach($result_set as $row) {
					$menu = new Menus($row['menu_id']);
					$this->menuList[] = $menu;
				}
			} else {
				$error->addMessage("You have no menus in your Database");
				return false;
			}
		}
		
		
		
		
/*  ===========================================
	Admin Methods
	========================================= */	
	
		//Add Menu
		
		//Update Menu
		
		//Delete Menu
		
	
	
	}
	
	
	
?>
