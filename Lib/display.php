<?php 

	class display {
		private $user;
		private $user_access;
		private $navTitle; 
		private $contentTitle;
		private $navigation_id;
		private $content_id;
		private $content;
		
		//URL
		private $parentURL;
		private $childURL;
		
		
		//Public Attributes
		public $companyAddress;
		public $companyPhones = array();
		
		
		public function __construct($urlTitle="", $contentTitle="") {
			//Sanitze URLS from .htaccess File
			if ($urlTitle == NULL) $urlTitle = $this->navTitle;
			$this->navTitle = $this->sanitizeURL($urlTitle);
			$this->contentTitle = $this->sanitizeURL($contentTitle);
			
			//Setup Content
			if ($this->navTitle == "ads") {
				$this->getAds();
			} else if ($this->navTitle == 'news') {
				$this->getNews();
			} else if ($this->navTitle == 'content') {
				$this->getContent();
			} else {
				$this->getContent();
			}
			
			//Verify and setup User
			if (!empty($_SESSION['user_id'])) {
				$this->user = new Users($_SESSION['user_id']);	
			} else {
				 $this->user = new Users();
			}
			
			//Get information for Company
			$this->getCompanyInformation();
			
		}
		
		private function sanitizeURL($url) {
			$url = urldecode($url);
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
			
		

/*  ===========================================
	Navigation Methods
	========================================= */
	
	
		public function displayMenu($menu_name) {
			$menu = new Menus(Menus::menuFromName($menu_name));
			$navigation = new Navigation();
			
			$navigation->listNav($menu->menu_id);
			
			$html = '<ul>';
			foreach ($navigation->itemList as $list) {
				
				//If Login Button
				if ($list->title == 'Login') {
					if ($this->user->isLoggedIn()) {
						$list->title = 'Log Out';
						$list->link = '/logout.html';	
					}
				}
				
				//If register Button
				if (($list->title == 'Join') && ($this->user->isLoggedIn())) {
					continue;	
				}
				
				if (($list->access <= $this->user->access) && ($list->published == 1)) {
					$title = urlencode($list->title);
					if ($list->link == NULL) {
						$this->parentURL = DS.str_replace("+", "_", $title).DS;
					} else {
						$this->parentURL = $list->link;	
					}
					
					$html.= '<li><a href="'.$this->parentURL.'" ';
					if (($this->navTitle == $list->title) || ($this->navTitle == NULL && $list->default_page == 1) ) {
						$html .= 'class="active"';
					}	
					
					$html .= '>'.$list->title.'</a>';
					
					if ($list->subNavList != false) {
						$html .= "<ul>";
						foreach ($list->subNavList as $subNav) {
							if (($subNav->access <= $this->user->access) &&($subNav->published == 1)) {  
							if ($subNav->link == NULL) {
								$title = urlencode($subNav->content_title);
								$this->childURL= $this->parentURL.str_replace("+", "_", $title);
							} else {
								$this->childURL = $subNav->link;
							}
							
							//Pint
							$html .= '<li><a href="'.$this->childURL.'" ';
							if ($this->contentTitle == $subNav->content_title) {
								$html .= ' class="active"';
							}
							
							$html .=  '>'.$subNav->title.'</a></li>';
							}
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
		
		public function getContent() {
			//Content Title only
			if ((!empty($this->navTitle)) && (empty($this->contentTitle))) {
				$this->content = new Content(Navigation::contentIdFromTitle($this->navTitle));
			} else if ((!empty($this->navTitle)) && (!empty($this->contentTitle))){
				$this->content = new Content(Content::contentFromTitle($this->contentTitle));
			} else if (empty($this->navTitle) && (empty($this->contentTitle))) {
				$this->content = new Content(Navigation::defaultNavigation());
			}	
		}
		
		public function getAds() {
			$this->content = new Ads(Ads::adIdFromTitle($this->contentTitle));
		}
		
		public function getNews() {
			$this->content = new news(News::newsIdFromTitle($this->contentTitle));
			
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
			$news->listNews();
			
			$html = '<ul class="news">';
			foreach ($news->newsList as $item) {
				$item->summary = strip_tags($item->summary);
				
				if ($item->published == 0 || $item->access > $this->user->access) continue;
				$html .= '<li>';	
				$html .= '<h4><a href="'.$item->directLink.'">'.$item->title.'</a></h4>';
				$html .= '<p>'.$item->summary.'</p>';
				$html .= '</li>';	
			}
			
			$html .= "</ul>";
			return $html;
		}
		
		public function displayAds($placement) {
			$ads = new Ads();
			$ads->listAds();
			
			$adDisplay = '<div class="ads"><div class="scroll">';
			foreach($ads->adList as $item) {
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
			<div class="numbers"></div>
			</div>';
			
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
			$size = 2;
			
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