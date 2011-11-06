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
	
	public function duplicate($file_name) {
		global $db;
		
		$result_set = $db->queryFill("SELECT * FROM media WHERE file_name = '{$file_name}'");
		
		if ($result_set != false) {
			foreach ($result_set as $row) {
				return $row['media_id'];	
			}
		} else {
			return false;	
		}
	}
	
	public function placeThumbnail() {
		$ext = end(explode('.', $this->file_name));
		
		if ($ext == 'doc' || $ext == 'docx') { 
			return '/images/admin/word.jpg';
		} else if ($ext == 'pdf') {
			return '/images/admin/pdf.jpg';
		} else {
			return $this->file_link;
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
	public function createMedia($post) {
		global $error;
		
		$this->fillFromForm($post);
		$this->file_link = $this->directory . $post['file_name'];
		$media_id = $this->save($this->media_id);
	   
		if (isset($media_id)) {
			return $media_id;
		} else {
			$error->addError('The information did not save.', 'Media1284');	
		}
	}
	
	
	
	//Delete
	public function deleteFromForm() {
		global $error;
		
		if ($this->delete($this->media_id)) {
			$this->recursiveDelete();
			return true;
		} else {
			$error->addError('the information did not save.' ,'Media1564');	
		}
	}
	
	//Delete File
	private function recursiveDelete(){
      if (is_file(FILE_PATH.DS.$this->file_name)) {
			return @unlink(FILE_PATH.DS.$this->file_name);  
	  }
	}
	
	
/* ========================================
	Redefine Methods 
	==================================== */
	
}// /Class
?>
