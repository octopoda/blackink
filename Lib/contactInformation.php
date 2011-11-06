<?php
   	require_once("databaseObject.php");
	
    class contactInformation extends databaseObject{
        
        public $table = "contactInformation";
        public $idfield = "contact_id";
        
        public $contact_id;
		public $email;
		public $address_id;
		public $phonenumber;
		public $faxnumber;
		public $summary; 
		
        public function __construct() {
            $result = $this->fetchById(1);
			$this->address = new Address($this->address_id); 
        }
		
		
		public function createFromForm($post) {
			global $error;
			
			$this->fillFromForm($post);
			
			$address = new Address();
			$address->fillFromForm($post);
			$this->address_id = $address->save($address->address_id);
			
			if ($this->save($this->contact_id)) {
				$error->addMessage('Your Contact Information has been saved');	
				return true;	
			} else {
				$error->addError('The information did not save.', 'Contact1248');
				return false;	
			}
			
			
		}
		
		
		
		
	}
?>
