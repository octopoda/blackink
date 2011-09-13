<?php
 	require_once('database.php');
	require_once('errors.php');
	require_once('thumbnails.php');
	require_once('project.php');
   
    class ThumbnailView {
        
       	
		public $thumbnailList = array();
		public $projectList;
		public $category_name;
		public $thumbCount; 
		
        public function __construct($cat_name) {
			global $db;
			global $error;
			
			$this->category_name = $cat_name;
			
			$result = $db->queryFill("SELECT * FROM vw_thumbnail WHERE category_name = '{$cat_name}' AND active = 1 ORDER BY position");
			
			if ($result != false) {
				
				$count = count($result);
				if ($count == 1) $result = array_shift($result);
								
				for ($i = 0; $i < $count; $i++) {
					//Set up Thumbnails
					$thumbnail = new Thumbnails($result[$i]['thumbnail_id']);
					$this->thumbnailList[] = $thumbnail;
					
					//Setup Projects
					$project = new Project($result[$i]['project_id']);
					$this->projectList[] = $project;
				}
				
				$this->thumbCount = count($this->thumbnailList);
			} else {
				$error->addError("Sorry there are no projects for this category.");	
			}
           
        }
		
		public function printThumbnailList () {
			$html = '<ul>';
			
			
			for($i = 0; $i < $this->thumbCount; $i++)  {
				$thumb = new Thumbnails($this->thumbnailList[$i]->thumbnail_id);
				$project = new Project($this->projectList[$i]->project_id);
				
				$link = "cadence_projects.php?catName={$this->category_name}&project={$project->linkedTitle}";
				
				$html .= '<li><a href="'. $link .'">' .$thumb->thumbnailImage() . '</a>'  ;
				$html .= '<a href="'. $link.'">'. $project->projectTitle. '</a>';
				$html .= '</li>';
			}
			
			$html .= '</ul>';
			
			return $html;
		}
		
	}
?>
