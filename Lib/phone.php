<?php
	require_once("databaseObject.php");
    
    //Class and Table need to be the same name
    class Phone extends databaseObject{
        
        public $table = "phone";
        public $idfield = "phone_id";
        public $allowCache = false;
		public $phone_id;
		public $phone_type;
		public $phonenumber;

		//Helpers
		public $phonetypename;
		public $contactName;

		public function __construct($p_id = "") {
			global $db;
			
			if (!empty($p_id)) {
				$result = $db->queryFill("SELECT * FROM phone JOIN phoneType ON phone.phone_type = phoneType.phone_type WHERE phone_id= {$p_id} LIMIT 1");
			
				if ($result != false) {
					$result = array_shift($result);
					$this->instantiate($result, $this);
				}
			}
		}
		
		public function cleanPhoneType() {
			switch ($this->phone_type) {
				case "HP":
					$this->phone_type = "Home";
					break;
				case "CP":
					$this->phone_type = "Cell";
					break;
				case "WK":
					$this->phone_type = "Work";
					break;	
			}
				
		}
		
		public function updatePhone($name, $id ) {
			global $db;
			
			switch ($name) {
				case "camper":
					$table = "phonesForCampers"; 
					$column = "camper_id";
					break;
				case "church":
					$table = "phonesForChurch"; 
					$column = "church_id";
					break;
				case "user":
					$table = "phonesForUsers"; 
					$column = "user_id";
					break;	
			}
			
			
			$results = $db->query("SELECT * FROM {$table} WHERE {$column} = {$id} AND phone_id = {$this->phone_id}");
			
			if ($db->numRows($results) > 0) {
				return;
			} else {
				$query = $db->query("INSERT INTO {$table} (phone_id, {$column}) VALUES ({$this->phone_id}, {$id})");	
			}
			
				
		}
	}
?>