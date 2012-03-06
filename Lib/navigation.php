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
		public $type;
		public $directLink;
		
		//Helpers
		public $itemList;
		public $subNavList;
		public $parentList;
		public $content_id;
		public $content_title;
		
		
		
		 public function __construct($n_id="") {
			 if (empty($n_id)) $n_id = $this->navigation_id;
			
			if (!empty($n_id)) {
         		$result = $this->fetchById($n_id);
				$this->matchContent(); 
				
				if ($this->type == 3) {
					
				}
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
	
	static function defaultNavigation() {
		global $db;
		
		$result = $db->queryFill("SELECT navigation_id FROM navigation WHERE default_page = 1");
		
		if ($result != false) {
			foreach ($result as $row) {
				$navigation = new Navigation($row['navigation_id']);
				return $navigation->content_id;	
			}
		} else {
			return false;	
		}
	}
	
	
	static function contentIdFromDirectLink($link) {
		global $db; 
		
		$result = $db->queryFill("SELECT NC.content_id FROM navigation N JOIN navigationForContent NC ON N.navigation_id = NC.navigation_id WHERE N.directLink = '{$link}' ");
		
		if ($result != false) {
			foreach ($result as $row) {
				return $row['content_id'];	
			}
		}
	}	
	
	
		
	
	
	
	public function buildNavigation($parentName ="") {
		if ($this->published == 0) return;
		
		switch ($this->type) {
			case 1:
				return $this->contentLink($parentName);
				break;
			case 2: 
				return $this->externalLink();
				break;
			default:
				return $this->compassLink($title);
				break;	
		}
		
	}
	
	
	
	private function externalLink() {
		$URL = $this->link;	
		$html = '<li><a href="'.$URL.'">'.$this->title.'</a>';
		
		return $html;
	} 
	
	private function contentLink($parentName="") {
		if (!empty($parentName)) { //Child
			$URL = DS.$parentName.DS.$this->directLink.'.html';	
		} else { //Parent
			$URL = DS.$this->directLink.DS;	
		}
		
		$html = '<li><a href="'.$URL.'">'.$this->title.'</a>';	
		
		return $html;
	}
	
	

/*  ===========================================
	CRUD METHODs
	========================================= */	
	
		//Create From Form
		public function createNavigationFromForm($post) {
			global $error;
			global $db;
			
			$this->fillFromForm($post);
			$this->directLink = $this->sanitize($this->title, true);
			
			$oldPostion;
			
			switch ($_POST['type']) {
				//Content
				case 1: 
					$this->link = '';
					break;
				//External
				case 2:
					$this->content_id = '';
					$this->content_title = '';
					break;
				//Compass
				case 3:
					break;	
			}
			
			
			//Edit Navigation Position Set
			if ($this->navigation_id != false) {
				$positionNav = new Navigation($this->navigation_id);
				$oldPosition = $positionNav->position;
				$this->navigation_id = $this->save($this->navigation_id);
				$this->setPosition($this->position, $oldPosition, $this->parent_id, $this->menu_id);
			
			//New Navigation Position Set
			} else {
				$this->position = $this->position+1;// 6  
				$position_set = $db->queryFill("SELECT position FROM navigation WHERE menu_id = {$this->menu_id} AND parent_id = {$this->parent_id} AND position = {$this->position} LIMIT 1");										 				
				if ($position_set != false) {
					$position_set = $this->arrayShift($position_set);
					$setPosition = $position_set['position']; 
					$newPosition = $setPosition+1;
					$this->setPosition($newPosition, $setPosition, $this->parent_id, $this->menu_id);
					$this->navigation_id = $this->save($this->navigation_id);	
				} else {
					$this->navigation_id = $this->save($this->navigation_id);
				}
			}
			
			
			//Insert Content
			if (!empty($this->content_id)) {
				$this->placeContent($this->content_id, $this->navigation_id);
			}
			
			
			return $this->navigation_id; 
			
		}
		
		
		public function deleteFromForm() {
			global $error;
			
			$newPosition = $this->bottomPosition($this->position, $this->parent_id, $this->menu_id);
			$this->setPosition($newPosition, $this->position, $this->parent_id, $this->menu_id);
			
			if ($this->navigation_id == 31 || $this->navigation_id == 33 ) {
				$error->addMessage("This cannot be deleted.");
				return false;
			}
			
			switch($this->type) {
				case 1:
					$this->removeContent($this->navigation_id);
					break;
				case 3:	
					break;
			}
			
			if ($this->delete($this->navigation_id)) {
				$error->addMessage("Navigation was deleted");
			} else {
				$error->addError('Navigation did not delete.', 'Navigation1564');	
			} 
		}
		
		public function setDefault($n_id="") {
			global $error;
			global $db;
			
			if (empty($n_id)) $n_id = $this->navigation_id;
			
			$query1 = $db->query("UPDATE navigation SET default_page = 0");
			$query2 = $db->query("UPDATE navigation SET default_page = 1, access = 1, published = 1 WHERE navigation_id = {$n_id}");
			
			if ($db->affectedRows() > 0) {
				return true;	
			} else {
				$error->addError("Your defualt page could no be set.", 'Navigation1568');
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
				$created = $db->queryFill("SELECT content_id FROM navigationForContent WHERE navigation_id = {$navigation_id}");
				
				if ($created != false) {
					return true;	
				} else {
					$error->addError('The content was not added.', 'Navigation2654');	
				}
		}
		
		private function removeContent($navigation_id) {
			global $db;
			$db->query("DELETE FROM navigationForContent WHERE navigation_id =  {$navigation_id}");	
		}
		
		
		
		
		
	
		//List Navigation for Menus
		public function listNav($menu_id) {
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
			$html = '<label for="parent_id">Dropdown Under</label>';
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
			
			
			$html = '<label for="position">Postion (Place Below Selection)</label>';
			$html .=  '<select name="position" id="position" class="changePosition">';
			
			$sql = "SELECT position, title FROM {$this->table} WHERE menu_id = {$menu_id} AND parent_id = {$parent_id} ORDER BY position";
			$result_set = $db->queryFill($sql);
			
			if ($result_set != false) {
				$html .= '<option value="0">Top</option>';
				foreach ($result_set as $row) {
					$html .= '<option value="'. $row['position'].'">'.$row['title'].' ('.$row['position'].')</option>';	
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
	XML Methods
	========================================= */	
	
	static public function listAllNav() {
		global $db;
		
		$result_set = $db->queryFill("SELECT * FROM navigation");
		
		if ($result_set != false) {
			return $result_set;	
		}
	}
	
	public function xmlLink() {
		$html = "";
		
		if ($this->default_page == 1) {
			$html = "index.html";
			return $html;
		}
		
		if ($this->published != 1) {
			return;	
		}
		
		if ($this->parent_id == 0) {
			$html = $this->directLink;	
		} else {
			$parent = new Navigation($this->parent_id);
			$html .= $parent->directLink."/".$this->directLink.'.html';	
		}
		
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
			
			if ($position != $this->bottomPosition($position, $parent, $menu_id)) {
				$html .= '<a sel="'.$id.'" class="move ninjaSymbol ninjaSymbolMoveDown" title="moveDown" href="'.$link.'" parent="'.$parent.'" menu="'. $menu_id.'"></a>';
			}
			
			
			$html .= '</li></ul>';
			return $html;	
	}
	
	
	//Find out if item is in bottom position
	public function bottomPosition($position, $parent, $menu_id) {
		global $db;
		
		$result = $db->queryFill("SELECT max(position) AS 'position' FROM {$this->table} WHERE parent_id = {$parent} AND menu_id = {$menu_id}");
		$result = array_shift($result);
		return $result['position'];
	}
	
	
	} //Class Ending
	
	
	
?>
