<?php
   	require_once("databaseObject.php");
	
    class Site extends databaseObject{
        
        public $table = "site";
        public $idfield = "site_id";
        
        public $site_id;
		public $siteName;
		public $siteDescription;
		public $googleCode;
		public $keywords;
		public $siteURL;
		
        public function __construct() {
            $result = $this->fetchById(1); 
        }
		
		
		public function createFromForm($_POST) {
			global $error;
			
			$this->fillFromForm($_POST);
			
			if ($this->save($this->site_id)) {
				$error->addMessage('Your Site has been saved');	
				return true;	
			} else {
				$error->addError('The information did not save.', 'Site1248');
				return false;	
			}
			
			
		}
		
		
		
		
	}
?>
