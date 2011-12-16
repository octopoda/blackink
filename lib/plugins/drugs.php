<?php
   	require_once(CLASS_PATH.DS."databaseObject.php");
	
    class Drugs extends databaseObject{
        
        public $table = "drugs";
        public $idfield = "drug_id";
        
        public $drug_id;
		public $drugName;
		public $drugUse;
		public $content;
		public $searchable;
		public $published;
		public $user_id;
		public $access;
		public $created_on;
		public $modified_on;
		public $modified_by;
		
		
		//Helper Functions
	
		public function __construct($d_id="") {
           if (empty($d_id)) $d_id = $this->drug_id;
			
			if (!empty($d_id)) {
         		$result = $this->fetchById($d_id);
				$this->getLink();
			} 
        }
/* ========================================
	Build/Helper Methods 
	==================================== */	 
	
	static function drugFromName($title) {
		global $db;
		global $error;
		
		$result = $db->queryFill("SELECT drug_id FROM drugs WHERE title = '{$drugName}'");
		
		if ($result != false) {
			foreach ($result as $row) {
				return $row['drug_id'];	
			}
		} else {
			return false;	
		}
	}
	
	private function getLink() {
		$title = str_replace(" ", "-", $this->drugName);
		$this->directLink = '/compass/'	.urlencode($title);
	}
	
	
	static function drugsFromName($name) {
		global $db;
		
		$result_set = $db->queryFill("SELECT drug_id FROM drugs WHERE drugName = '{$name}' LIMIT 1");
		
		if ($result_set != false) {
			$result = array_shift($result_set);
			return $result['drug_id'];
		}
	}
		
		
/* ========================================
	Display Methods 
	==================================== */
		
	static public function searchContent($searchTerm, $limit = null) {
		global $db;
		
		if (empty($limit)) {
			$sql = "SELECT * FROM drugs WHERE searchable LIKE '%{$searchTerm}%' OR title LIKE '%{$searchTerm}%'";	
		} else {
			$sql = "SELECT * FROM drugs WHERE searchable LIKE '%{$searchTerm}%' OR title LIKE '%{$searchTerm}%'" . $limit;
		}
		
		$result_set = $db->queryFill($sql);	
		return $result_set;
	}	
		
/* ========================================
	Admin Methods 
	==================================== */
	
	//CRU
	public function createDrugsFromForm($post) {
		global $error;
		
		$this->fillFromForm($post);
		
		if ($this->drug_id == NULL) {
			$this->created_on = $this->setCreateDate();
		}
		
		if ($this->user_id == NULL) {
			$this->user_id = $this->modified_by; 	
		}
		
		
		$this->searchable = strip_tags($_POST['content']);
		$drug_id = $this->save($this->drug_id);
		
		if (!empty($drug_id)) {
			return $drug_id;
		} else {
			$error->addError('The information did not save.', 'Drugs1284');	
		}
	}
	
	
	
	//Delete
	public function deleteFromForm() {
		global $error;
			
			if ($this->delete($this->drug_id)) {
				return true;
			} else {
				$error->addError('The information did not save.', 'Drugs1564');	
			}
	}
	
	//Set Create Date 
	private function setCreateDate() {
		 return date("Y-m-d h:i:s");
	}

/* ========================================
	Redefine Methods 
	==================================== */
	
}// /Class
?>
