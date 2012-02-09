<?php
   	require_once("databaseObject.php");
	
    class Social extends databaseObject{
        
        public $table = "social";
        public $idfield = "social_id";
        
        public $social_id;
		public $facebook_url;
		public $twitter_url;
		public $linkedin_url;
		public $foursquare_url;
		public $last_fm_url;
		public $tumblr_url;
		public $google_url;
		
		
        public function __construct() {
            $result = $this->fetchById(1);
		}
		
		
		public function createSocialFromForm($post) {
			global $error;
			
			$this->fillFromForm($post);
			
			
			if ($this->save($this->social_id)) {
				$error->addMessage('Your Social Information has been saved');	
				return true;	
			} else {
				$error->addError('The information did not save.', 'Social1248');
				return false;	
			}
			
			
		}
		
	}
?>
