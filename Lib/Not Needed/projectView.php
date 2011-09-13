<?php
 	require_once('databaseObject.php');
	$link = "cadence_projects.php?catName=";
	
	//Helper Class to Projects that extends 
    class ProjectView extends DatabaseObject {
        
    	public $project_id;
		public $active;
		public $position;
		public $category_name;
		public $category_id;
		public $thumbnail_id;  
		
		
		public $projectList;
		public $thumbnailList;
		
		
		
		//Get one project at a time and gives all the information
		public function __construct($project_id) {
			global $db;
			
			$result = $db->queryFill("SELECT * FROM vw_projectView WHERE project_id = {$project_id} LIMIT 1");
			
			if ($result != false) {
				$result = array_shift($result);
				$this->instantiate($result, $this);
			}
		}
		
		//Get all Projects for a Category
		public static function listProjectsForCategory($category_name) {
			global $db;
			
			$result = $db->queryFill("SELECT * FROM vw_projectView WHERE category_name = '{$category_name}' ORDER BY position");
			
			if ($result != false) {
				
				if (count($result) == 1) {
					$result = array_shift($result);
					$proj = new Project($result['project_id']);
					$proj->position = $result['position'];
					$proj->category_id = $result['category_id'];
					$projectList[] = $proj;	
					
				} else {
					foreach($result as $project) {
						$proj = new Project($project['project_id']);
						$proj->position = $project['position'];
						$proj->category_id = $project['category_id'];
						$projectList[] = $proj;
					}
				}
				
				return $projectList;
			} else {
				return;
			}
			
			
		}
		
	//FrontEnd Methods
		//Build the Slideshow
		public static function buildSlideshow($imageList) {
			$html = '<div id="slider">';
			if (empty($imageList)) return;
			
			foreach($imageList as $image) {
				$html  .= '<img src="'.$image->filePath.$image->file_name.'" alt="'.$image->image_alt.'" class="slideshow" width="619" />';
			}
			
			$html .= '</div>';
			
			return $html;
		}
		
		//Build Thumbnails for Category
		public static function buildThumbnailForCategory($catName, $link) {
			
			$catName = str_replace("_", " ", $catName);
			
			$projectList = ProjectView::listProjectsForCategory($catName);
			
			$projectArray = array();
			
			if ($projectList != false) {
				$html ='<ul class="thumbnailList">';
				
				foreach ($projectList as $project) {
					$projectLink = $link. $project->linkedTitle .'.php';
					
					if ($project->active == 1) {
						$projectArray[] = $project->projectTitle;
						
						$thumbnail = new Thumbnails($project->projectView->thumbnail_id);
						$html .= '<li>
									<a href="'.$projectLink.'">'.$project->projectTitle.'</a><br />
									<a href="'.$projectLink.'">'. $thumbnail->thumbnailImage() .'</a>
								</li>';	
					} else {
						
					}
				}
			
			$html .= "</ul>";
			} else {
				
			}
			
			if ($projectArray == NULL) {
				$html = "<h5>There are no projects for this category.</h5>";
			}
			
			
			
			return $html;
		}
		
		//Build Sidebar with More Projects
		public static function moreProjects($catName, $projectTitle, $link) {
			$catName = str_replace("_", " ", $catName);
			
			$projectList = ProjectView::listProjectsForCategory($catName);
			
			
			
			$html = '<h4>More Projects</h4>';
			$html .= '<ul>';
			if ($projectList != false && count($projectList) > 1) {
				
				foreach($projectList as $project) {
					$projectLink = $link. $project->linkedTitle .'.php';
					if ($projectTitle != $project->projectTitle) {
						$html .= '<li><a href="'. $projectLink .'">'.$project->projectTitle.'</a></li>';
					}
				}
				
				$html .= '</ul>';
				return $html;	
			} else {
				return;
			}
		}
		
		public static function printProject($projectTitle) {
			$id = Project::getIdFromTitle($projectTitle);
			
			$project = new Project($id);
			$html = '<div class="projectImages">';
			$html .= '<h3 class="projecTitle">'. $project->projectTitle.'</h3>';
			$html .= ProjectView::buildSlideshow($project->imageList);
			$html .= '</div>';
			$html .= '<div class="projectInfo">';
			if (!empty($project->objective)) {
				$html .= '<h4>Objective</h4>';
				$html .= '<div class="objective">'. $project->objective.'</div>';
			}
			if (!empty($project->testimonial)) {
				$html .= '<h4>Testimonial</h4>';
				$html .= '<div class="testimony"><blockquote>'. $project->testimonial.'</blockquote><p class="homeOwners">&mdash;'.$project->names.'</p></div>';
			}
			$html .= '</div>';
			return $html;	
		}
		
		public static function printFeaturedProject() {
			$proId = Project::getFeaturedProject();
			$project = new Project($proId);
			$thumbnail = new Thumbnails($project->projectView->thumbnail_id);
			
			if ($project->project_id != false) {
				$html = '<div class="featuredProject">';
				$html .= '<h5>Featured Project</h5>';
				
				$html .=  $thumbnail->thumbnailImage();
				$html .=  substr($project->objective,0, 600);
				$html .= '<a href="'.  $project->projectLink .'">...learn more</a></div>';
				return $html;
			} else {
				return;	
			}
		}
		
		
	//Backend Methods
		//List all of the projects
		public static  function projectPreview($link, $projectList) {
			
			$html = '<table class="listing">
						<tr class="tableHeader">
							<td>Project Title</td>
							<td>Position</td>
							<td>Published</td>
							<td>Featured</td>
						</tr>';
			foreach	($projectList as $project) {
				$html .='<tr>
							<td>
								<a class="edit" href="forms/project_information.php?sel='.$project->project_id.'">'.$project->projectTitle.'</a>
							</td>
							<td>'. $project->position . $project->moveArrows($project->project_id, $project->projectView->position, $link) .'</td>
							<td>'. $project->published($project->project_id) .'</td>
							<td>';
								if ($project->featured == 1) {
									$html .= '<img src="/images/admin/featured_star.png" alt="featured" />';	
								} else {
									$html .= '<a href="forms/project_list.php" class="featureProject" sel="'.$project->project_id.'">Feature Project</a>';	
								}
						$html .=	'</td>    
						</tr>';
			}	
			$html .= '</table>';
            
			return $html;
		}
		
		//List all Images for Projects
		public static function previewImages($imageList, $link) {
			if ($imageList == NULL) {
				return "<h5>There are no images associated with this project.</h5>";
			}
			$html = "<table>
						<tr>
							<td>Preview</td>
							<td>Position</td>
							<td>Delete</td>
						</tr>";
			
			foreach ($imageList as $image) {
				$html .= '<tr>
							<td>'.$image->printImage($image->image_id, 100).'</td>
							<td>'. $image->position.  $image->moveArrows($image->image_id, $image->position, $link.'?sel='.$image->project_id) .'</td>
							<td><a class="deleteImage" sel="'. $image->image_id.'" href="'.$link.'">Delete Image</a></td>
						  </tr>';
			}
			
			$html .= '</table>';
			
			return $html;
		}
		
		
		
	}
?>
