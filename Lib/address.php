<?php 
require_once("databaseObject.php");

    
    //Class and Table need to be the same name
    class Address extends databaseObject{
        
        public $table = "address";
        public $idfield = "address_id";
        public $allowCache = false;
		public $address_id;
		public $address1;
		public $address2;
		public $city;
		public $state_id;
		public $zip;

		//Helpers
		public $statename;
		public $code;
		public $country;

		public function __construct($a_id="") {
			global $db;
			if (!empty($a_id)) {
				$result = $db->queryFill("SELECT * FROM address A JOIN states S ON A.state_id = S.state_id WHERE A.address_id = {$a_id} LIMIT 1");
				
				if ($result != false) {
					$result = array_shift($result);
					$this->instantiate($result, $this);
				}
			}
		}

        public function pushToForm() {
            global $db;

		    $html = "<script> ";
            foreach($this->attributes() as $k => $v) {
               $html .= "$('#".$k."').val('".$db->escapeString($v)."'); ";
            }
            $html .= "$('#statename').val('".$this->statename."'); ";
            $html .= "$('#code').val('".$this->code."'); ";
            $html .= "$('country').val('".$this->country."'); ";
            $html .= "</script>";

            return $html;
        }
        
		public function  printAddress($a_id = "") {
			if (empty($a_id)) $a_id = $this->address_id;
			
			$address = new Address($a_id);
			
			$html = '<address>' .
						$address->address1 . '<br />';
						 
			if (!empty($address->address2)) 
			$html  .=  $address->address2 . '<br />';
			
			$html .=    $address->city . ", " .
						$address->code . "  " .
						$address->zip .
						'</address>';
			
			return $html;	
		}
		
	   	public static function stateSelect() {
			global $db;
		
			$result = $db->queryFill("SELECT * FROM states ORDER BY state_id");
			if ($result != false) {
				$html = '<select name="state_id" id="state_id">';
				
				foreach ($result as $state) {
					$html .= '<option value="'. $state['state_id'].'">'.$state['statename'].'</option>';
				}
				$html .= '</select>';	
			}
		
			return $html;
		}
		
		//Save
		public function saveForForm() {
			$this->address_id = $this->save($this->address_id);
			return $address_id;
		}
		
		//Add Addresses
		public function addAddressToUser($u_id) {
			global $db;
			
			$result_set = $db->queryFill("SELECT * FROM addressForUser WHERE user_id = {$u_id}");
			
			if ($result_set == false) {
				//Insert
				$db->query("INSERT INTO addressForUser (address_id, user_id) VALUES ('{$this->address_id}', '{$u_id}')");
				if ($db->affectedRows() > 0) return true;
			} 	
		}
		
		
		public function deleteFromForm() {
			global $db;
			
			$db->query("DELETE FROM addressForUser WHERE address_id = {$this->address_id}");
			$this->delete($this->address_id);
		}
		
		
	}



?>