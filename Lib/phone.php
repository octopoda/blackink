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
		
		
		//SAve and Update
		public function updatePhone($id ) {
			global $db;
			
			$results = $db->query("SELECT * FROM phoneForUser WHERE user_id = {$id}");
			
			if ($db->numRows($results) > 0) {
				return;
			} else {
				$query = $db->query("INSERT INTO phoneForUser (phone_id, user_id) VALUES ({$this->phone_id}, {$id})");	
			}
			
				
		}
		
		public function deleteFromForm() {
			global $db;
			
			$db->query("DELETE FROM phoneForUser WHERE phone_id = {$this->phone_id}");
			$this->delete($this->phone_id);	
		}
	}
?>