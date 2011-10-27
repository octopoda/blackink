<?php
   	require_once("databaseObject.php");
	
    class Ads extends databaseObject{
        
        public $table = "ads";
        public $idfield = "ad_id";
        
        public $ad_id;
		public $title;
		public $published;
		public $position; 
		public $user_id; 
		public $placement;
		public $summary;
		public $content;
		
		//Helper Functions
		public $adList;
		public $humanPlacment;
		
        public function __construct($a_id="") {
           if (empty($a_id)) $a_id = $this->ad_id;
			
			if (!empty($a_id)) {
         		$result = $this->fetchById($a_id);
				$this->placementHumanReadable(); 
			} 
        }
/* ========================================
	Build/Helper Methods 
	==================================== */	 
	
	public function placementHumanReadable() {
		
		switch ($this->placement) {
			case 0:
				$this->humanPlacment = 'Front Page';
				break;
			case 1: 
				$this->humanPlacment = 'Side Bar';
				break;
			case 2: 
				$this->humanPlacment = 'Both';
				break;	
		}
	}
	
		
		
/* ========================================
	Display Methods 
	==================================== */
		
	public function searchContent($searchQuery) {
				
	}	
		
/* ========================================
	Admin Methods 
	==================================== */
	
	//CRU
	public function createAdsFromForm($post) {
		global $error;
		
		$this->fillFromForm($post);
		
		
		
		$ad_id = $this->save($this->ad_id);
	   
		if (isset($ad_id)) {
			return true;
		} else {
			$error->addError('The information did not save.', 'Ads1284');	
		}
	}
	
	
	
	//Delete
	public function deleteFromForm() {
		global $error;
			
		if ($this->delete($this->ad_id)) {
			return true;
		} else {
			$error->addError('the information did not save.' ,'Ads1564');	
		}
	}
	
	
/* ========================================
	Redefine Methods 
	==================================== */
	
}// /Class
?>
