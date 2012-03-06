<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');
	
	class sitemap {
		public $loc;
		public $lastMod;
		public $changeFreq;
		public $priority;
		public $sections = array(); 
		public $navigation; 
		
		
		
		
		public function __construct($sections="") {
			//Sections is an array
			if (!empty($sections)) $this->sections = $sections;
			
			$this->output();
		}
		
		public function  setURL($location, $modified,  $frequency, $priority) {
			$xml = '<url>';
			$xml .= '<loc>http://'.$location.'</loc>';
			$xml .= '<lastmod>'.$modified.'</lastmod>';
			$xml .= '<changefreq>'.$frequency.'</changefreq>';
			$xml .= '<priority>'.$priority.'</priority>';
			$xml .= '</url>';
			
			return $xml;
		}
		
		
		private function output() {
			$site = new Site();
			
			$this->xml = '<code><?xml version="1.0" encoding="UTF-8"?>
		  	 <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
			 
			//Run through navigation
			$navList = Navigation::ListAllNav();
			foreach ($navList as $navigation) {
				$nav = new Navigation($navigation['navigation_id']);
				$content = new Content($nav->content_id);
				
				
				if ($nav->access >= 2) continue;
				
				if ($nav->xmlLink() != NULL) {
					$loc = $site->siteURL;
					$mod = $content->created_on;
					$changeFreq = 'monthly';
					$priority = 1.0; 
					
					
					if ($nav->xmlLink() != 'index.html') {
						$loc .= DS.$nav->xmlLink();
						$priority = $content->priority;
						$changeFreq = $content->frequencyToPrint();	
					} else if ($nav->link != NULL) {
						$loc .= DS.$nav->link;
						$priority = 0.6;
						$changeFreq = 'monthly';
						
					}
					
					if ($content->modified_on != NULL) $mod = $content->modified_on;
					
					if (!empty($mod)) {
						$mod = date("Y-m-d", strtotime($mod));	
					}
					
					$this->xml .= $this->setURL($loc, $mod, $changeFreq, $priority);
				}
			}
			
			//Run through any other sections needed. 
			foreach ($this->sections as $classname) {
				$class = new $classname();
				$all = $class->fetchAll();
				
				
				foreach ($all as $piece) { 
					
					$loc = $site->siteURL.DS.'blog'.DS.$piece['directLink'].'.html';
					$mod = $piece['publish_date'];
					$priority = 0.6;
					$changeFreq = 'never';
					
					$this->xml .= $this->setURL($loc, $mod, $changeFreq, $priority);
				}
			}
			
			 
			
			$this->xml .= "</urlset></code>";
		}
		
		
		
	} //end class


?>