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
		
		public function buildSocialArray() {
			$array = array();
			
			$set = get_object_vars($this);
			
			unset($set['table']);
			unset($set['idfield']);
			unset($set['social_id']);
			
			foreach ($set as $k=>$v) {
				$class = substr($k, 0, -4);
				$array[$class] = $v;
			}
			
			return $array;
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
