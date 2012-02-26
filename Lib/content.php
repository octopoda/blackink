<?php
   	require_once("databaseObject.php");
	
    class Content extends databaseObject{
        
        public $table = "content";
        public $idfield = "content_id";
        
        public $content_id;
		public $user_id;
		public $created_on;
		public $published;
		public $modified_on;
		public $title;
		public $access;
		public $content;
		public $modified_by;
		public $searchable;
		public $summary;
		
		//Helper Functions
		public $objectList;
		public $directLink;
		public $keywords = array();
		public $keywordList = array();
		public $printKeywords;

		
        public function __construct($c_id="") {
           if (empty($c_id)) $c_id = $this->content_id;
			
			if (!empty($c_id)) {
         		$result = $this->fetchById($c_id);
				$this->directLink = $this->createLink("content", $this->title);
				$this->keywords = $this->keywordsForContent();
				$this->printKeywords = $this->keywordsForPrint();
			} 
        }
/* ========================================
	Build/Helper Methods 
	==================================== */	 
	
	static function contentFromTitle($title) {
		global $db;
		global $error;
		
		$result = $db->queryFill("SELECT content_id FROM content WHERE title = '{$title}'");
		
		if ($result != false) {
			foreach ($result as $row) {
				
				return $row['content_id'];	
			}
		} else {
			return false;	
		}
	}
	
	
	
	
	
		
		
/* ========================================
	Display Methods 
	==================================== */
		
	static public function searchContent($searchTerm, $limit = null) {
		global $db;
		
		if (empty($limit)) {
			$sql = "SELECT * FROM content WHERE searchable LIKE '%{$searchTerm}%' OR title LIKE '%{$searchTerm}%'";	
		} else {
			$sql = "SELECT * FROM content WHERE searchable LIKE '%{$searchTerm}%' OR title LIKE '%{$searchTerm}%'" . $limit;
		}
		
		$result_set = $db->queryFill($sql);	
		return $result_set;
	}
		
		
/* ========================================
	Admin Methods 
	==================================== */
	
	//CRU
	public function createContentFromForm($post) {
		global $error;
		
		$this->fillFromForm($post);
		
		if ($this->content_id == NULL) {
			$this->created_on = $this->setCreateDate();
		}
		
		if ($this->user_id == NULL) {
			$this->user_id = $this->modified_by; 	
		}
		
		$this->modified_on = date("Y-m-d h:i:s");
		$this->searchable = strip_tags($post['content']);
		$this->summary = strip_tags($post['summary']);
		
		$content_id = $this->save($this->content_id);
		
		if ($post['keywords'] != false) {
			$keys = explode(",", $post['keywords']);
			$this->listKeywords();
			
			$this->checkKeywords($keys, $content_id);
			
			foreach ($keys as $k) {
				$k = trim($k);
				if (in_array($k, $this->keywordList)) {
					$key = array_search($k, $this->keywordList);
					$this->connectKeyword($key, $content_id);
				} else {
					$this->insertKeyword($k, $content_id);	
				}
			}
		}
		
		if (!empty($content_id)) {
			return $content_id;
		} else {
			$error->addError('The information did not save.', 'Content1284');	
		}
	}
	
	
	
	//Delete
	public function deleteFromForm() {
		global $error;
			
			if ($this->delete($this->content_id)) {
				return true;
			} else {
				$error->addError('The information did not save.', 'Content1564');	
			}
	}
	
	//Set Create Date 
	private function setCreateDate() {
		 return date("Y-m-d h:i:s");
	}

/* ========================================
	Keyword Methods 
	==================================== */
	
	private function checkKeywords($keyArray, $content_id) {
		global $db;
		$bool = false;
		$erase = array();
		$delete = array();
		
		//Compare array to keywords for content
		$keyInContent = $this->keywordsForContent($content_id);
		$same =  $this->_array_diff($keyInContent, $keyArray);
		
		if ($same != false) {
			foreach ($same as $s) {
				$result = $db->queryFill("SELECT KC.content_id, K.keyword_id FROM keywords K JOIN keywordsForContent KC ON K.keyword_id = KC.keyword_id WHERE K.keyword = '{$s}'");
				if ($result != false) {
					foreach ($result as $id) {
						if ($content_id == $id['content_id']) {
							$erase[] = $id['keyword_id'];
						} else {
							$delete[] = $id['keyword_id'];	
						}
					}	
				} else {
					return; //No content id so don't worry about it
				}	
			}
			$trueDelete = $this->_array_diff($erase, $delete);
			
			foreach ($trueDelete as $e) {
				$db->query("DELETE FROM keywordsForContent WHERE keyword_id = '{$e}' AND content_id = {$content_id}");
				$db->query("DELETE FROM keywords WHERE keyword_id = {$e}");	
			}
			
			foreach ($delete as $d) {
				$db->query("DELETE FROM keywordsForContent WHERE keyword_id = '{$d} and content_id = {$content_id}'");
			}
		}
	}
	
	private function _array_diff($a, $b) {
		$map = $out = array();
		foreach($a as $val)  {$val = trim($val); $map[$val] = 1 ; }
		foreach($b as $val)  {$val = trim($val); if(isset($map[$val])) $map[$val] = 0 ; }
		foreach($map as $val => $ok) if($ok) $out[] = $val;
		return $out;
	}
	
	
	private function listKeywords() {
		global $db;
		
		$result_set = $db->queryFill("SELECT * FROM keywords");
		
		if ($result_set != false) {
			foreach ($result_set as $keywords) {
				$this->keywordList[$keywords['keyword_id']] = $keywords['keyword'];
			}
		}
	}
	
	public function keywordsForContent($content_id="") {
		global $db;
		$keys = array();
		
		if (empty($content_id)) $content_id = $this->content_id;
		
		$sql = "SELECT keyword, K.keyword_id FROM keywords K 
					JOIN keywordsForContent CK ON CK.keyword_id = K.keyword_id
					WHERE CK.content_id = {$content_id}";
		
		$result_set = $db->queryFill($sql);
		
		if ($result_set != false) {
			foreach ($result_set as $keyword) {
				$keys[$keyword['keyword_id']] = $keyword['keyword'];	
			}
		} 
		return $keys;
	}
	
	private function insertKeyword($keyword, $content_id) {
		global $db;
		
		$db->query("INSERT INTO keywords (keyword) VALUES ('{$keyword}')");
		$id = $db->insertedID();
		
		$db->query("INSERT INTO keywordsForContent (keyword_id, content_id) VALUES ('{$id}', '{$content_id}')");
	}
	
	private function connectKeyword($keyword_id, $content_id) {
		global $db;
		
		$test_set = $db->queryFill("SELECT * FROM keywordsForContent WHERE keyword_id = {$keyword_id} AND content_id = {$content_id}");
		
		if ($test_set != false) {
			return;	
		} else {
			$db->query("INSERT INTO keywordsForContent (keyword_id, content_id) VALUES ('{$keyword_id}', '{$content_id}')");	
		}
	}
	
	
	public function keywordsForPrint() {
		$string = ''; 
		
		if ($this->keywords != false) {
			foreach($this->keywords	as $key) {
				$string = $string. $key.', ';	
			}
		}
		
		return substr($string, 0, -2);
	}
	
	
}// /Class
?>
