<?php 

	class display {
		private $user;
		private $user_access;
		private $navTitle; 
		private $contentTitle;
		private $navigation_id;
		private $content_id;
		
		//URL
		private $parentURL;
		private $childURL;
		
		
		public function __construct($urlTitle="", $contentTitle="") {
			if ($urlTitle == NULL) $urlTitle = $this->navTitle;
			$this->navTitle = $this->sanitizeURL($urlTitle);
			$this->contentTitle = $this->sanitizeURL($contentTitle);
			
			if (!empty($_SESSION['user_id'])) {
				$this->user = new Users($_SESSION['user_id']);	
			} 
		}
		
		private function sanitizeURL($url) {
			$url = str_replace("/", "", $url);
			$url = str_replace("_", " ", $url);
			
			return $url;
		}
		
/*  ===========================================
	SEO Methods
	========================================= */		
		
		public function displayPageTitle() {
			$spacer = " - ";
			if ($this->contentTitle != NULL) {
				return $spacer . $this->contentTitle;
			} else if ($this->contentTitle == NULL and $this->navTitle != NULL) {
				return $spacer . $this->navTitle;	
			} else {
				return;	
			}
		}


/*  ===========================================
	Navigation Methods
	========================================= */
	
	
		public function displayMenu($menu_name) {
			$menu = new Menus(Menus::menuFromName($menu_name));
			$navigation = new Navigation();
			
			$navigation->listNav($menu->menu_id);
			
			$html = '<ul>';
			foreach ($navigation->itemList as $list) {
				if ($list->access <= $this->user->access) {
					$this->parentURL = DS.str_replace(" ", "_", htmlentities($list->title)).DS;
					$html.= '<li><a href="'.$this->parentURL.'" ';
					if (($this->navTitle == $list->title) || ($this->navTitle == NULL && $list->default_page == 1) ) {
						$html .= 'class="active"';
					}	
					
					$html .= '>'.$list->title.'</a>';
					
					if ($list->subNavList != false) {
						$html .= "<ul>";
						foreach ($list->subNavList as $subNav) {
							$this->childURL= $this->parentURL.str_replace(" ", "_", htmlentities($subNav->content_title));
							
							$html .= '<li><a href="'.$this->childURL.'" ';
							if ($this->contentTitle == $subNav->content_title) {
								$html .= ' class="active"';
							}
							
							$html .=  '>'.$subNav->title.'</a></li>';
						}
						$html .= "</ul>";
					}
					$html .= "</li>";
				}
			}
			$html .= '<ul>';
				
			echo $html;
		}


/*  ===========================================
	Content Methods
	========================================= */		
		
		public function displayContent() {
			if ($this->contentTitle != NULL) {
				$content = new Content(Content::contentFromTitle($this->contentTitle));
			} else if ($this->contentTitle == NULL && $this->navTitle != NULL){
				$content = new Content(Content::contentFromTitle($this->navTitle));
			} else {
				$content = new Content(Navigation::defaultNavigation());
			}	
			
			echo $content->content;
		}
	} //end class
?>