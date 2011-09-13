<?php
   	require_once("databaseObject.php");
	
    
    //Class and Table need to be the same name
    class Testimonials extends databaseObject{
        
        public $table = "testimonials";
        public $idfield = "testimonial_id";
        
        public $testimonial_id;
		public $testimonial_text;
		public $testimonial_title;
		public $position;
		public $project_id;
		public $signature;
		public $active;
		
		public $testimonialList = array();
		public $link = "testimonials.php?catName=";
  
        public function __construct($t_id="") {
			if (empty($t_id)) $t_id = $this->testimonial_id;
			
			if (!empty($t_id)) {
         		$result = $this->fetchBySQL("SELECT * FROM testimonials WHERE testimonial_id = {$t_id}"); 
			} 
        }
		
		public function setupObject($t_id) {
			return new Testimonials($t_id);
		}
		
		public function listTestimonies() {
			global $db;
			global $error;
			
			$result = $db->queryFill('SELECT * FROM testimonials ORDER BY Position');
			
			if ($result != false) {
			
				$count = count($result);
				if ($count == 1) $result = array_shift($result);
				
				for($i = 0; $i < $count; $i++) {
					$test = new Testimonials($result[$i]['testimonial_id']);
					$this->testimonialList[] = $test;
				}
			} else {
				$error->addError("You have no testimonials in your database.");	
			}
			
		}
		
		public function deleteFromForm() {
			global $db; 
			
			$this->setPosition($this->bottomPosition(), $this->position);
			$this->delete($this->testimonial_id);	
			
			return ($db->affectedRows() > 0);
		}
		
		
	}
?>
