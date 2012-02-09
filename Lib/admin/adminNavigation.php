<?php
	require_once(CLASS_PATH.DS."databaseObject.php");


	//All Navigation pieces for the Admin 
    class AdminNavigation extends databaseObject {
      	public $table = "adminNavigation";
        public $idfield = "admin_id";
		
		public $admin_id;
		public $title;
		public $link;
		public $access;
		public $position;
		public $published;
		public $parent_id;
		
		//Helper Attributes
		public $mainNav = array();
		public $tabs = array();
		private $user;
		
		//Create the Main Navigaton
		public function __construct ($a_id="") {
			if ($a_id == false) $a_id = $this->admin_id;
			
			$this->user = new Users($_SESSION['user_id']);
			
			if (!empty($a_id)) {
				$this->fetchById($a_id);
				$this->listTabs($a_id);
			} else {
				$this->listMainNav();	
			}
			
			
			
		}

/* =======================================
	Setup and Helper Methods
   ===================================== */
		public function listMainNav() {
			global $db;
			
			$result_set = $db->queryFill("SELECT admin_id FROM adminNavigation WHERE parent_id = 0 AND published = 1 ORDER BY position");
			foreach ($result_set as $row) {
				$this->mainNav[] = new AdminNavigation ($row['admin_id']);	
			}
		}
		
		public function listTabs($id) {
			global $db;
			
			$tab_set = $db->queryFill("SELECT admin_id FROM adminNavigation WHERE parent_id = {$id} AND published = 1 ORDER BY Position");
			foreach ($tab_set as $row) {
				$this->tabs[] = new AdminNavigation($row['admin_id']);
			}
		}
    	
		
		
		
	
		//Display Navigation 
		public function displayMainNavigation() {
			$html = '<ul>';
			$nTimes = 0;
			
			foreach ($this->mainNav as $mainNav) {
				if ($mainNav->access <= $this->user->access) {
					$html .= '<li';
					if ($nTimes == 0) $html .= ' class="active" ';
					$html .= '><a href="'.$mainNav->link.'" sel="'.$mainNav->title.'">'.$mainNav->title.'</a></li>';
					$nTimes++;
				}
			}
			
			$html .= '</ul>';
			
			echo $html;
		}
		
		public function displayTabNavigation($title) {
			$html = '<ul>';
			$nTimes = 0;
			
			foreach ($this->mainNav as $mainNav) {
				if ($mainNav->title == $title) {
					foreach ($mainNav->tabs as $tabs) {
						if ($tabs->access <= $this->user->access) {
							$html.= '<li'; 
							if ($nTimes == 0) $html .= ' class="active" ';
								
							$html .= '><a href="'.$tabs->link.'" sel="'.$tabs->title.'" >'.$tabs->title.'</a></li>';
							$nTimes++;	
						}
					}
				}
			}
			
			$html .= '</ul>';
			
			return $html;
		}
	}
?>
