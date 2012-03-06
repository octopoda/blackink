<?php 

	class search {
		public $searchTerm;
		public $classes = array();
	
		
		
		public function __construct($classes="") {
			if (empty($classes)) $this->classes[] = 'content';
			else $this->classes = $classes;
		}
		
	
		
		
		public function search($searchTerm, $limit = null) {
			global $db;
			$sql = '';
			$result_array = array();
			
			
			
			for($i=0; $i < count($this->classes); $i++) {
				$name = $this->classes[$i];
				$class = new $name();
				
				
				if (empty($limit)) {
					$sql .= "SELECT title, directLink, searchable, {$class->idfield} AS 'id', '${name}' as 'table' FROM {$this->classes[$i]} WHERE searchable LIKE '%{$searchTerm}%' OR title LIKE '%{$searchTerm}%' ";	
				} else {
					$sql .= "SELECT title, directLink, searchable, {$class->idfield} As 'id', '${name}' as 'table' FROM {$this->classes[$i]} WHERE searchable LIKE '%{$searchTerm}%' OR title LIKE '%{$searchTerm}%' ";
				}
				
				$total = count($this->classes)-1;
				if ($i != $total) {
					$sql .= " UNION ALL ";
				} else {
					$sql .= $limit;	
				}
			}
			
			$result_set = $db->queryFill($sql);
			return $result_set;
		}
		
		private function totalSearch($searchTerm) {
			global $db;
			$sql = "";
			
			for($i=0; $i < count($this->classes); $i++) {
				$sql .= "SELECT title,  searchable FROM {$this->classes[$i]} WHERE searchable LIKE '%{$searchTerm}%' OR title LIKE '%{$searchTerm}%' ";	
				
				$total = count($this->classes)-1;
				if ($i != $total) {
					$sql .= " UNION ALL ";
				}	
				
			}
			
			return $db->queryFill($sql);
				
		}
	
		
		public function siteSearch($string, $pageNumber) {
			global $db;
			
			
			$totalSize = count($this->totalSearch($string));
			
			$page = 1;
			$size = 10;
			
			if (isset($pageNumber)) $page = $pageNumber; 
 			 
			 //echo 'page:'.$page.' size:'.$size.' totalSize:'.$totalSize;
			$pagination = new Pagination();
			$pagination->setupPagination($page, $size, $totalSize);
			$pagination->setSearch($string);
			
			$result_set = $this->search($string, $pagination->getLimitSql()); 
			
			if ($result_set != false) {
				echo $this->buildSearch($result_set);
				echo $pagination->create_links();
			} else {
				echo '<h3>No items matched your search.</h3>';		
			}
		}
		
		
		
		public function titleSearch($string) {
			global $db;
			
			$result_set = $db->queryFill("SELECT title FROM content WHERE title LIKE '%".$string."%'");	
			return $result_set;
		}
		
		
		
		private function buildSearch($result_set) {
			global $db;
			$html = '';
			
			
			foreach ($result_set as $v) {
				$name = $v['table'];
				$class =  new $name($v['id']);
				
				$html .= '<div>';	
				$html .= '<h3><a href="'.$class->directLink.'">'.$class->title.'</a></h3>';
				$html .= '<p>'. truncate($class->searchable, 400, " ",'...').'</p>';	
				$html .= '</div>';
				
			}
		
			return $html;
		}
		
		
		
/*  ===========================================
	Helper Methods
	========================================= */		
		
		
		public function truncate($string, $limit, $break=".", $pad="...") {
			if(strlen($string) <= $limit) return $string;

  			if(false !== ($breakpoint = strpos($string, $break, $limit))) {
				if($breakpoint < strlen($string) - 1) {
			  		$string = substr($string, 0, $breakpoint) . $pad;
				}
  			}
			
			return $string;
		}
		
	} //end class
?>