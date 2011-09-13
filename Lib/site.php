<?php
   	require_once("databaseObject.php");
	
    class Site extends databaseObject{
        
        public $table = "site";
        public $idfield = "site_id";
        
        public $site_id;
		public $siteName;
		public $siteDescription;
		
        public function __construct($p_id="") {
           
        }
		
		
		
		
		
	}
?>
