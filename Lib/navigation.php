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
		public $menu_id;
		
		//Helpers
		public $navigationList;
		public $subNavList;
		public $menuList;
		
		 public function __construct($n_id="") {
			 if (empty($n_id)) $n_id = $this->navigation_id;
			
			if (!empty($n_id)) {
         		$result = $this->fetchById($n_id); 
			}
			
			
		}
		
/*  ===========================================
	Build Methods
	========================================= */	

			
		

/*  ===========================================
	Display Methods
	========================================= */	
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
			
			$sql = "SELECT * FROM navigation WHERE menu_id = {$menu_id} AND parent = 0 ORDER BY position";
			
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
					$subNav = $db->queryFill("SELECT * FROM navigation WHERE parent = " . $this->itemList[$i]->navigation_id. " ORDER BY position");
					
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
				


/*  ===========================================
	Redefined Methods
	========================================= */


	public function setPosition ($newPosition, $varName, $parent, $menu_id) {
			global $db; 
			
			$position = $varName;
			
			$posLow = $position;
			$posHigh = $newPosition;
			
			if ($posLow > $posHigh) {
				$posLow = $newPosition;
				$posHigh = $position;
			}
			
			
			$db->query("UPDATE {$this->table} SET position = 4000 WHERE position = {$position} AND parent = {$parent} AND menu_id = {$menu_id}");
			$db->query("SELECT @sign:= SIGN({$position}-{$newPosition}) FROM {$this->table}");
			$db->query("UPDATE {$this->table} SET position = @sign + position WHERE position BETWEEN {$posLow} AND {$posHigh} AND parent = {$parent} AND menu_id = {$menu_id}");
			$db->query("UPDATE {$this->table} SET position = {$newPosition} WHERE position = 4000 AND parent = {$parent} AND menu_id = {$menu_id}");
			
			if ($db->affectedRows() > 0) {
			
			}
	}
	
	public function moveArrows ($id, $varName, $link, $parent, $menu_id) {
			$position = $varName;
			
			$html = '<ul class="moveArrows">
						<li class="'.$this->table.'" sel="'.$position.'">';
			if ($position != $this->topPosition($position)) {
				$html .='<a sel="'.$id.'" class="move ninjaSymbol ninjaSymbolMoveUp" title="moveUp" href="'.$link.'" parent="'.$parent.'" menu="'.$menu_id.'"></a>'; 
			}
			
			$html .=	'</li>
						<li class="'.$this->table.'" sel="'.$position.'">';
			
			if ($position != $this->bottomPosition($position)) {
				$html .= '<a sel="'.$id.'" class="move ninjaSymbol ninjaSymbolMoveDown" title="moveDown" href="'.$link.'" parent="'.$parent.'" menu="'. $menu_id.'"></a>';
			}
			
			
			$html .= '</li></ul>';
			return $html;	
	}
	
	
	} //Class Ending
	
	
	
?>
