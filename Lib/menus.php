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
				return false;
			}
		}
		
/*  ===========================================
	Display Methods
	========================================= */
		
	static function menuFromName($name) {
		global $db;
		
		$result_id = $db->queryFill("SELECT menu_id FROM menus WHERE menu_name = '{$name}'");
		
		if ($result_id != false) {
			foreach ($result_id as $result) {
				return $result['menu_id'];	
			}
		}
	}
		
		
/*  ===========================================
	Admin Methods
	========================================= */	
	
		//Add Menu
		
		public function createMenuFromForm($post) {
			global $error;
			
			$this->fillFromForm($_POST);
			 
			if ($this->save($this->menu_id)) {	
				return true;	
			} else {
				$error->addError('The information did not save.', 'Menu1284');
				return false;	
			}	
		}
		
		//Update Menu
		
		//Delete Menu
		public function deleteFromForm() {
			if ($this->delete($this->menu_id)) {
				return true;	
			} else {
				$error->addError('The information did not save.', 'Menu1564');	
			}
		}
		
		public static function bottomMenu() {
			global $db;
			global $error;
			
			$sql = "SELECT menu_id FROM menus LIMIT 1 ";
			$result_set = $db->queryFill($sql);
			
			if ($result_set != false) {
				$menu = new Menus();
				$result_set = $menu->arrayShift($result_set);
				return $result_set['menu_id'];
			} else {
				$error->addError('Please add a menu first before trying to add Navigation');
				return false;	
			}
		}
	
	
	}
	
	
	
?>
