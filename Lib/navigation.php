<?php
	require_once('databaseObject.php');
	
	class Navigation extends databaseObject {
      	public $table = "navigation";
        public $idfield = "navigation_id";
		
		public $navigation_id;
		public $title;
		public $parent_id;
		public $access;
		public $position;
		public $published;
		public $link;
		public $menu_id;
		public $default_page;
		
		//Helpers
		public $navigationList;
		public $subNavList;
		public $parentList;
		public $content_id;
		public $content_title;
		
		
		 public function __construct($n_id="") {
			 if (empty($n_id)) $n_id = $this->navigation_id;
			
			if (!empty($n_id)) {
         		$result = $this->fetchById($n_id);
				$this->matchContent(); 
			}
			
			
		}
		
/*  ===========================================
	Build Methods
	========================================= */	
		public function matchContent() {
			global $db;
			
			$sql = "SELECT NC.content_id, C.title FROM navigationForContent NC JOIN content C ON NC.content_id = C.content_id WHERE navigation_id = {$this->navigation_id} LIMIT 1";
			$result_set = $db->queryFill($sql);
			
			if ($result_set != false) {
				foreach ($result_set as $row) {
					$this->content_id = $row['content_id'];
					$this->content_title = $row['title'];
				}
			} else {
				return false;	
			}
		}
			
		

/*  ===========================================
	Display Methods
	========================================= */	
		//Create Main Navigation
		
		
		//Create Dropdowns
		
		//Attach Navigation to Content
		
		//Display Navigtion 	
	

/*  ===========================================
	CRUD METHODs
	========================================= */	
	
		//Create From Form
		public function createNavigationFromForm($post) {
			global $error;
			
			$this->fillFromForm($post);
			$oldPosition = 0;
			
			if ($this->navigation_id != false) {
				$positionNav = new Navigation($this->navigation_id);
				$oldPostion = $positionNav->position;
			} 
			
			$this->setPosition($this->position, $oldPosition, $this->parent_id, $this->menu_id);
			
			//Save
			$this->navigation_id = $this->save($this->navigation_id);
			$saveNav = new Navigation($this->navigation_id);
			
			//IF save worked place the content together with the navigation
			if ($saveNav->navigation_id != false && $post['content_id'] != false) {
				$this->placeContent($post['content_id'], $this->navigation_id);
				return true;
			} else if ($saveNav->link) { 
				return true;
			}else  {
				$error->addError('The information did not save.  Please report the error id: #Navigation1284');
				return false;	
			} 
		}
		
		public function deleteFromForm() {
			global $error;
			
			if ($this->delete($this->navigation_id)) {
				return true;
			} else {
				$error->addError('the information did not save.  Please report the error id: #Navigation1564');	
			}
		}
		
		public function setDefault($n_id="") {
			global $error;
			global $db;
			
			if (empty($n_id)) $n_id = $this->navigation_id;
			
			$query1 = $db->query("UPDATE navigation SET default_page = 0");
			$query2 = $db->query("UPDATE navigation SET default_page = 1 WHERE navigation_id = {$n_id}");
			
			if ($db->affectedRows() > 0) {
				return true;	
			} else {
				$error->addError("Your defualt page could no be set.  Plase report the error id: #Navigation1568");
			}
		}

/*  ===========================================
	Admin Methods
	========================================= */
		//Place Content with Navigation 
		public function placeContent($content_id, $navigation_id) {
				global $db;
				global $error;
				
				//Check to see if Navigation is defined already 
				$sql = "SELECT * FROM navigationForContent WHERE navigation_id = {$navigation_id}";
				$set = $db->queryFill($sql);
				
				//Else Insert
				if ($set == false) {
					$sql = "INSERT INTO navigationForContent (content_id, navigation_id) VALUES ({$content_id},{$navigation_id})";
				//If defined Update
				} else {
					$sql = "UPDATE navigationForContent SET content_id = {$content_id} WHERE navigation_id = {$navigation_id}";
				}
				
				$db->query($sql);
				
				if ($db->affectedRows() > 0) {
					return true;
				} else {
					$error->addError('I could not add Content to your navigation.  Plase report the error id: #Navigation2654');	
				}
		}
		
	
		//List Navigation for Menus
		function listNav($menu_id) {
			global $db;
			global $error;
			
			$sql = "SELECT * FROM navigation WHERE menu_id = {$menu_id} AND parent_id = 0 ORDER BY position";
			
			$result_set = $db->queryFill($sql);
			if ($result_set != false) {
				
				//Get navigation 
				foreach($result_set as $row) {
					$navigation = new Navigation($row['navigation_id']);
					$this->itemList[] = $navigation;
				}
				
				//Get the Subnav and place them in itemList
				for ($i = 0; $i < count($this->itemList); $i++) {
					$subNav = $db->queryFill("SELECT * FROM navigation WHERE parent_id = " . $this->itemList[$i]->navigation_id. " ORDER BY position");
					
					foreach ($subNav as $nav) {
						$sub = new Navigation($nav['navigation_id']);
						$this->itemList[$i]->subNavList[] = $sub;	
					}	
					
				}
				
				
				
			} else {
				$this->itemList = NULL;
				return false;
			}
			
		}
		
		public function listParents($menu_id) {
			global $db;
			global $error;
			
			$sql = "SELECT title, navigation_id FROM navigation WHERE menu_id = {$menu_id} AND parent_id = 0 ORDER BY position";
			
			$result_set = $db->queryFill($sql);
			if ($result_set != false) {
				
				$this->parentList[] = 'None';
				foreach ($result_set as $name) {
					$this->parentList[$name['navigation_id']] = $name['title']; 	
				}	
			} else {
				$this->parentList[] = 'None';	
			}
		}
		
		public function parentDropDown() {
			$html = '<label for="parent_id">Parent Navigation</label>';
			$html .= '<select name="parent_id" id="parent_id">';
			
			foreach ($this->parentList as $k=>$v) {
				$html .= '<option value="'.$k.'">'.$v.'</option>';	
			}
				
			$html .= '</select>';
			
			return $html;	
		}
		
		public function positionDropDown($menu_id="", $parent_id="") {
			global $db;
			global $error;
			
			
			if ($menu_id === false) $menu_id = $this->menu_id;
			if ($parent_id === false) $parent_id = $this->parent_id;
			
			
			$html = '<label for="position">Postion (Set below)</label>';
			$html .=  '<select name="position" id="position" class="changePosition">';
			
			$sql = "SELECT position, title FROM {$this->table} WHERE menu_id = {$menu_id} AND parent_id = {$parent_id} ORDER BY position";
			$result_set = $db->queryFill($sql);
			
			if ($result_set != false) {
				$html .= '<option value="0">Top</option>';
				foreach ($result_set as $row) {
					$html .= '<option value="'. $row['position'].'">'.$row['title'].' -('.$row['position'].')</option>';	
				}
			} else {
				$html .= '<option value="0">Top</option>';
			}
			
			$html .= "</select>";
			return $html;	
		}

	public function displayDefault($link) {
		global $db;
		
		$html = '<a href="'.$link.' "id="'.$this->navigation_id.'" class="ninjaSymbol ninjaSymbolStar setDefault ';
		
		if ($this->default_page == 1) {
			$html .= 'active';	
		}
		
		$html .= '"></a>';
		
		return $html;
	}

/*  ===========================================
	Redefined Methods
	========================================= */


	public function setPosition ($newPosition, $oldPosition, $parent, $menu_id) {
			global $db; 
			
			$position = $oldPosition;
			
			$posLow = $position;
			$posHigh = $newPosition;
			
			if ($posLow > $posHigh) {
				$posLow = $newPosition;
				$posHigh = $position;
			}
			
			
			$db->query("UPDATE {$this->table} SET position = 4000 WHERE position = {$position} AND parent_id = {$parent} AND menu_id = {$menu_id}");
			$db->query("SELECT @sign:= SIGN({$position}-{$newPosition}) FROM {$this->table}");
			$db->query("UPDATE {$this->table} SET position = @sign + position WHERE position BETWEEN {$posLow} AND {$posHigh} AND parent_id = {$parent} AND menu_id = {$menu_id}");
			$db->query("UPDATE {$this->table} SET position = {$newPosition} WHERE position = 4000 AND parent_id = {$parent} AND menu_id = {$menu_id}");
			
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
