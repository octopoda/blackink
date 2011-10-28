<?php
   	require_once("databaseObject.php");
	
    class Media extends databaseObject{
        
        public $table = "media";
        public $idfield = "media_id";
        
        public $media_id;
		public $file_name;
		public $file_link;
		
		public $directory = "/files/uploads/";
		
        public function __construct($m_id="") {
           if (empty($m_id)) $m_id = $this->media_id;
			
			if (!empty($m_id)) {
         		$result = $this->fetchById($m_id);
				
			} 
        }
/* ========================================
	Build/Helper Methods 
	==================================== */	 
	
	public function checkFileName($file_name) {
			if (strlen($file_name) >= 60) {
				echo "Sorry the file name is greater than 60 characters. Please change the file name and try again.";	
				return false;
			}
			
			return true;
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
	public function createMedia($post) {
		global $error;
		
		$this->fillFromForm($post);
		$this->file_link = $this->directory . $post['file_name'];
		$media_id = $this->save($this->media_id);
	   
		if (isset($media_id)) {
			return true;
		} else {
			$error->addError('The information did not save.', 'Media1284');	
		}
	}
	
	
	
	//Delete
	public function deleteFromForm() {
		global $error;
			
		if ($this->delete($this->ad_id)) {
			return true;
		} else {
			$error->addError('the information did not save.' ,'Media1564');	
		}
	}
	
	
/* ========================================
	Redefine Methods 
	==================================== */
	
}// /Class
?>
