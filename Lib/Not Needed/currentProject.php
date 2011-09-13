<?php
    require_once("databaseObject.php");
	require_once('posts.php');
    
    //Class and Table need to be the same name
    class CurrentProject extends databaseObject{
        
        public $table = "currentProject";
        public $idfield = "current_project_id";
        
        public $current_project_id;
		public $projectActive;
		public $projectTitle;
		public $deleted;
  
  		//helpers
		public $posts = array();
		public $lastestPost = array(); 
  		
        public function __construct() {
          	global $db;
		  
		   	$result = $db->queryFill("SELECT * FROM currentProject ORDER BY current_project_id DESC LIMIT 1");
		  	if ($result != false) {
				$result = array_shift($result);
				$this->instantiate($result, $this);
				$this->postInProject($this->current_project_id);
			}
        }
		
		private function postInProject() {
			global $db;
			
			$result = $db->queryFill("SELECT P.post_id FROM postInCurrent C JOIN posts P ON C.post_id = P.post_id WHERE C.current_project_id = {$this->current_project_id} ORDER BY P.postDate DESC");
			
			if ($result != false) {
				$count = count($result);
				if ($count == 1) {
					$result = array_shift($result);
					$post = new Posts($result['post_id']);
					$this->posts[] = $post;
					$this->latestPost = new Posts($post->post_id);		
				}else {
					for($i = 0; $i < $count; $i++) {
						$post = new Posts($result[$i]['post_id']);
						$this->posts[] = $post;
						if ($i == 0) $this->latestPost = new Posts($post->post_id);
					}
				}
			}
		}
		
		public function currentProjectActive ($p_id) {
			if ($p_id == 1) 
				return true; 
			else  
				return false;
		}
		
		public function setProjectActive ($p_id) {
			$this->projectActive = 1;
			$this->current_project_id = $this->save($p_id);	
			
			if ($this->current_project_id == $p_id) return true;	
		}
		
		public function setProjectUnactive($p_id) {
			$this->projectActive = 0;
			$this->current_project_id = $this->save($p_id);
			
			if ($this->current_project_id == $p_id) return true;
		}
		
    	public function printPosts() {
			$html = '<div class="article">';
			
			foreach ($this->posts as $post) {
				if ($post->active == 1) {
					$html .= $post->printPost();
				}
			}
				
			$html .= '</div>';
			
			return $html;
		}
		
		public function addPostToProject($p_id) {
			global $db;
			global $error;
			
			$result = $db->queryFill("SELECT * FROM postInCurrent WHERE post_id = {$p_id}");
			
			
			if ($result != false) {
				return false;	
			} else {
				$db->query("INSERT INTO postInCurrent (current_project_id, post_id) VALUES ('{$this->current_project_id}', '{$p_id}') ");
				return ($db->affectedRows() > 0);
			}	
		}
		
	}
	
	$currentProject = new CurrentProject();
?>
