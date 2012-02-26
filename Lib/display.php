<?php 

	class display {
		public $user;
		public $user_access;
		public $navTitle; 
		public $contentTitle;
		public $navigation_id;
		public $content_id;
		public $content;
		
		//URL
		private $parentURL;
		private $childURL;
		
		
		
		//Public Attributes
		public $companyAddress;
		public $companyPhones = array();
		
		
		
		public function navigationHandler($urlTitle="", $contentTitle="") {
			if ($urlTitle == NULL) $urlTitle = $this->navTitle;
			
			$this->navTitle = $urlTitle;
			$this->contentTitle = $contentTitle;
			
			
			echo 'navTitle='.$this->navTitle.'<br />';
			echo 'contentTitle='.$this->contentTitle.'<br />';
			
			//Find the Content - Content Methods
			if (array_key_exists($this->navTitle, $this->handler)) {
				$classname = $this->handler[$this->navTitle];
				$this->contentRequest($classname);
			} else {
				$this->navigationRequest();
			}
			
			//Get information for Company
			$this->getCompanyInformation();
		}
		
		
		public function setupUser() {
			if (!empty($_SESSION['user_id'])) { 
				$this->user = new Users($_SESSION['user_id']); 
			} else {	
				$this->user = new Users();
			}
			
			$this->user_access = $this->user->access;
		}
		
		
		
		
/*  ===========================================
	SEO Methods
	========================================= */		
		
		public function displayPageTitle() {
			$spacer = " - ";
			if ($this->contentTitle != NULL) {
				return $spacer . $this->contentTitle;
			} else if (($this->contentTitle == NULL) && ($this->navTitle != NULL)) {
				return $spacer . $this->navTitle;	
			} else {
				return;	
			}
		}
		
		public function displayPageDescription() {
			$site = new Site();
		
			if (empty($this->navTitle)) {
				return $site->siteDescription;	
			}
			
			if ($this->navTitle == 'ads') {
				$this->content->summary = strip_tags($this->content->summary);	
			}
			return $this->content->summary;
		} 
		
		public function displayKeywords() {
			$site = new Site();	
			
			if (isset($this->content->keywords)) {
				echo ($this->content->keywords != false) ? $this->content->keywordsForPrint() : $site->keywords;
			} else {
				echo $site->keywords;	
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
				if (($list->title == 'Join') && ($this->user->loggedIn)) {
					continue;	
				}
				
				if (($list->title == 'Login') && ($this->user->loggedIn)) {
					$list->title = "Log Out";
					$list->link = '/logout.html';	
				}
				
				if (($list->title == "profile") && !($this->user->loggedIn)) {
					continue;	
				}
				
				if ($this->user_access >= $list->access)
				 	$html .= $list->buildNavigation();
				
				if ($list->subNavList != false) {
					$html .= "<ul>";
					foreach ($list->subNavList as $subNav) {
						if ($this->user_access >= $list->access)
							$html .= $subNav->buildNavigation($list->directLink);	
					}
					$html .= "</ul>";
				}
			}
			
			$html .= '</ul>';
			
			echo  $html;
		}


/*  ===========================================
	Content Methods
	========================================= */		
		
		private function contentRequest($classname) {
			$class = new $classname();
			$id = $class->idFromLink($this->contentTitle);
			
			$this->content = new $class($id);
			
			
		}
		
		private function navigationRequest() {
			if ((!empty($this->navTitle)) && (empty($this->contentTitle))) {
				$this->content = new Content(Navigation::contentIdFromDirectLink($this->navTitle));
			} else if ((!empty($this->navTitle)) && (!empty($this->contentTitle))){
				$this->content = new Content(Navigation::contentIdFromDirectLink($this->contentTitle));
			} else if (empty($this->navTitle) && (empty($this->contentTitle))) {
				$this->content = new Content(Navigation::defaultNavigation());
			} 
		}
		
		
		
		
		public function displayTitle() {
			if (($this->navTitle = 'compass') && (!empty($this->drugList))) {
				echo $this->content->drugName;
			} else {
				echo $this->content->title;	
			}
		}
		
		public function displayContent() {
			if ($this->content->access <= $this->user->access) {
				echo $this->content->content;	
			} else {
				echo  '<h3>You do not have the rights to access this page.</h3>';	
			}
		}
		

		
		
		
		
/*  ===========================================
	Module Methods
	========================================= */
		
		public function displayNews() {
			$news = new News();
			$news->listNews(3);
			
			$html = '<ul class="news">';
			foreach ($news->newsList as $item) {
				$item->summary = strip_tags($item->summary);
				
				if ($item->published == 0 || $item->access > $this->user->access) continue;
				$html .= '<li>';	
				$html .= '<h4><a href="'. $item->directLink .'">'.$item->title.'</a></h4>';
				$html .= '<p>'.$item->summary.'</p>';
				$html .= '</li>';	
			}
			
			$html .= "</ul>";
			$html .= '<div class="newsTriangle"></div>';
			return $html;
		}
		
		public function displayAds($placement) {
			$ads = new Ads();
			$ads->listAds();
			
			
			
			$adDisplay = '<div class="scroll">';
			foreach($ads->adList as $item) {
				if ($item->placement == 1) {
					continue;	
				}
				$adDisplay .= '<div class="panel">';
				if (($placement == $item->humanPlacement) || ($item->humanPlacment == 'Both')) {
					$adDisplay .= $item->summary;
				} else if (($placement == $item->humanPlacement) || ($item->humanPlacement == 'Both')) {
					$adDisplay .= $item->summary;
				} 
				$adDisplay .= '<a href="'.$item->directLink.'" class="learnMore">Learn More</a>';
				$adDisplay .= '</div>';
			}
			$adDisplay .= '</div>
			<div class="numbers ir"></div>
			';
			
			echo $adDisplay;
		}
		
		
		public function randomAd($placement) {
			$ads = new Ads();
			$ads->listAds();
			$max = count($ads->adList) -1;
			
		
			$num = rand(0, $max);
			$item = $ads->adList[$num];
			
			if ($item->placement == 1) return;
			
			$adDisplay = '<div class="panelInside">';
			if (($placement == $item->humanPlacement) || ($item->humanPlacment == 'Both')) {
				$adDisplay .= $item->summary;
			} else if (($placement == $item->humanPlacement) || ($item->humanPlacement == 'Both')) {
				$adDisplay .= $item->summary;
			} 
			$adDisplay .= '<a href="'.$item->directLink.'" class="learnMore">Learn More</a>';
			$adDisplay .= '</div>';
			
			echo $adDisplay;
			
		}
		
/*  ===========================================
	Contact Methods
	========================================= */		
		
		private function getCompanyInformation() {
			$contact = new contactInformation();
			$address = new Address($contact->address_id);
			
			$this->phones['ph'] = $contact->phonenumber;
			$this->phones['fx'] = $contact->faxnumber;
			
			$this->companyAddress = $address->printAddress();
		}
		
		public function printAddress() {
			echo $this->companyAddress;	
		}
		
		public function printPhones() {
			$html = '<ul>';
			foreach ($this->phones as $key=>$value) {
				$html .= '<li>'.$key.': '.$value.'</li>';
			}
			
			$html .= "</ul>";
			echo $html;
		}
		
		
/*  ===========================================
	Search Methods
	========================================== */
		
		public function siteSearch($string, $pageNumber) {
			global $db;
			
			
			$totalSize = count(Content::searchContent($string));
			
			$page = 1;
			$size = 10;
			
			if (isset($pageNumber)) $page = $pageNumber; 
 			 
			$pagination = new Paginator($page, $size, $totalSize, $string);
			$result_set = Content::searchContent($string, $pagination->getLimitSql()); 
			
			if ($result_set != false) {
				echo $this->buildSearch($result_set);
				echo $pagination->create_links();
			} else {
				echo '<h3>No items matched your search.</h3>';		
			}
		}
		
		public function titleSearch($string) {
			global $db;
			
			$result_set = $db->queryFill("SELECT title FROM content WHERE title LIKE '%".$string."%'");	
			return $result_set;
		}
		
		private function buildSearch($result_set) {
			global $db;
			$html = '';
			
			foreach ($result_set as $row) {
				$content = new Content(Content::contentFromTitle($db->escapeString($row['title'])));
				
				$text = $row['content'];
				if (strlen($text) > 200) {
					$text = strip_tags($text);
 				   	$text = wordwrap($text, 200, "<br />");
					$text = substr($text, 0, strpos($text, "<br />"));
				}
				$html .="<div>";	
				$html .= '<h3><a href="'.$content->directLink.'">'.$row['title'].'</a></h3>';
				$html .= '<p>'. $text.'</p>';	
				$html .= '</div>';
			}
			
			return $html;
		}
		
	} //end class
?>