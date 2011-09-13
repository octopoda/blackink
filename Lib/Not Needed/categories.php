<?php
   	require_once("databaseObject.php");
	
    
    //Class and Table need to be the same name
    class Categories extends databaseObject{
        
        public $table = "categories";
        public $idfield = "category_id";
        
        public $category_id;
		public $category_name;
		public $position;
		public $active;
		
		public $categoryList = array();
		public $link;
		public $linkReadyName;
		
  		public function __construct($c_id="") {
			if (empty($c_id)) $c_id = $this->category_id;
			
			if (!empty($c_id)) {
         		$result = $this->fetchBySQL("SELECT * FROM categories WHERE category_id = {$c_id}"); 
				$this->setupLinkName();
			} 
        }
		
		public function setupObject($c_id) {
			return new Categories($c_id);
		}
		
		private function setupLinkName() {
			$this->linkReadyName = str_replace(" ", "_", $this->category_name);
		}
		
		//List all Categories
		public function listCategories() {
			global $db;
			global $error;
			
			$result = $db->queryFill('SELECT * FROM categories ORDER BY Position');
			
			if ($result != false) {
			
				$count = count($result);
				if ($count == 1) $result = array_shift($result);
				
				for($i = 0; $i < $count; $i++) {
					$cat = new Categories($result[$i]['category_id']);
					$this->categoryList[] = $cat;
				}
			} else {
				$error->addError("You have no categories in your database.");	
			}
		}
		
		//Front End Navigation
		public function categoryNavigation($catName) {
	 		$count = count($this->categoryList);
			
			$html ='<h4>Categories</h4>';
			$html .= '<ul class="categoryList">';
			
			$this->link = '/projects/';
			
			for($i= 0; $i < $count; $i++) {
				if ($this->categoryList[$i]->active == 1) {
					$html .= '<li><a href="'. $this->link. $this->categoryList[$i]->linkReadyName. '"';
					
					//Highlight the first one
					if ($this->categoryList[$i]->category_name == $catName) {
						$html .= ' class="active" ';	
					}
					$html .= '>'. $this->categoryList[$i]->category_name.'</a></li>';
				}
			}
			
			$html .= '</ul>';
			
			return $html;
 		}
		
		//Edit Category Name
		public static function changeCateogoryName($id, $category_name) {
				$cat = new Categories($id);
				$cat->category_name = $category_name;
				return $cat->save($cat->category_id);
		}
    
		//return top category name when category is not given for $_GET
		public function topCategory () {
			  $count = count($this->categoryList);
			  
			  for($i=0; $i < $count; $i++) {
			  	if ($this->categoryList[$i]->active == 1) {
					return $this->categoryList[$i]->category_name;
				}
			  }
		}
		
		//Get a Category Id From the Name
		public static function categoryIdForName ($categoryName) {
			$category = new Categories();
			$result = $category->fetchBySQL("SELECT * FROM categories WHERE category_name = '{$categoryName}'");
			return $category->category_id;
		}
		
		//Delete Category 
		public function deleteFromForm() {
			$this->setPosition($this->bottomPosition(), $this->position);
			return $this->delete($this->category_id);	
		}
	}
?>
