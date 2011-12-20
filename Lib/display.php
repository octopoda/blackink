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
		public $drugList;
		
		
		
		public function __construct($urlTitle="", $contentTitle="", $drugTitle="") {
			//Sanitze URLS from .htaccess File
			if ($urlTitle == NULL) $urlTitle = $this->navTitle;
			
			$this->navTitle = $this->sanitizeURL($urlTitle);
			$this->contentTitle = $this->sanitizeURL($contentTitle);
			$this->drugTitle = $this->sanitizeURL($drugTitle);
			
			//echo 'navTitle='.$this->navTitle.'<br />';
			//echo 'contentTitle='.$this->contentTitle.'<br />';
			//echo 'drug='.$this->drugTitle."<br />";
			
			//Verify and setup User
			if (!empty($_SESSION['user_id'])) {
				$this->user = new Users($_SESSION['user_id']);
			} else {
				 $this->user = new Users();
			}
			
			$this->user_access = $this->user->access;
			
			//Setup Content
			if ($this->navTitle == "ads") {
				$this->getAds();
			} else if ($this->navTitle == 'news') {
				$this->getNews();
			} else if ($this->navTitle == 'content') {
				$this->getContent();
			} else if (!empty($this->drugTitle)) {
				$this->getDrugs();
			} else if ($this->navTitle == 'compass') {
				$this->getCompass();
			} else if ($this->navTitle == 'supplements'){
				$this->getSupplements();
			} else {
				$this->getContent();
			}
			
			
		   
			
			//Get information for Company
			$this->getCompanyInformation();
		}
		
		
		//Santize the URLS
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
							$html .= $subNav->buildNavigation($list->title);	
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
		
		public function getContent() {
			//Content Title only
			if ((!empty($this->navTitle)) && (empty($this->contentTitle))) {
				$this->content = new Content(Navigation::contentIdFromTitle($this->navTitle));
			} else if ((!empty($this->navTitle)) && (!empty($this->contentTitle))){
				$this->content = new Content(Navigation::contentIdFromTitle($this->contentTitle));
			} else if (empty($this->navTitle) && (empty($this->contentTitle))) {
				$this->content = new Content(Navigation::defaultNavigation());
			} 
			
			
			if (empty($this->content->content)) {
				redirect('/404.html');	
			}
		}
		
		public function getAds() {
			$this->content = new Ads(Ads::adIdFromTitle($this->contentTitle));
			if (empty($this->content->content)) {
				redirect('/404.html');	
			}
		}
		
		public function getNews() {
			$this->content = new news(News::newsIdFromTitle($this->contentTitle));
			if (empty($this->content->content)) {
				redirect('/404.html');	
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
	Compass Methods
	========================================= */		
		public function getCompass() {
			//redirect for user access
			if ($this->user_access < 2) {
				redirect('/no_access.html');	
			}
			
			$this->drugList = Navigation::drugListFromTitle($this->contentTitle);
			if ($this->drugList == false) {
				$this->content = new Content(Navigation::contentIdFromTitle($this->contentTitle));	
			} else {
				$this->content = new Drugs($this->drugList[0]->drug_id);	
			}
			
			
			if (empty($this->content->content)) {
				redirect('/404.html');	
			}
		}
		
		public function getDrugs() {
			$this->drugList = Navigation::drugListFromTitle($this->contentTitle);
			$this->content = new Drugs(Drugs::drugsFromName($this->drugTitle));
			
			if (empty($this->content->content)) {
				redirect('/404.html');	
			}
		}
		
		public function drugNavigation() {
			$html  = '<h3>'.$this->contentTitle.'</h3>';
			$html .= '<ul class="drugList">';
			
			foreach ($this->drugList as $drug){
				if (($drug->published == 0) || ($this->user_access <= $drug->access)) continue;
				$title = $this->prepareLink($this->contentTitle);
				$drugName = $this->prepareLink($drug->drugName);
				$link = DS.'compass'.DS.$title.DS.$drugName.'.html';
				
				$html .= '<li><a href="'.$link.'">'.$drug->drugName.'</a></li>';
					
			}
			
			$html .= "</ul>";	
			echo $html;
		}
		
		private function prepareLink($string) {
			$string = rawurlencode($string);
			return str_replace("%20", "-", $string);	
		}
		

/*  ===========================================
	Supplement Methods
	========================================= */			
		
		private function getSupplements() {
			$supplement = new Supplements();
			
			if ($this->contentTitle != false) {
				$product = $supplement->supplementIdFromTitle($this->contentTitle);
				$this->content = $supplement->displayFullSupplement($product);
				return;	
			} else {
				$frontpage = $supplement->frontpage();
				$this->content =  $supplement->displayFullSupplement($frontpage);	
				return;
			}
 		}
		
		
		public function displaySupplements() {
			if ($this->content != false) {
				echo $this->content;
			} else {
				redirect('/404.html');
			}
		}
		
		public function supplementNavigation() {
			$supplements = new Supplements();
			
			$html = '<h5>Our Featured Supplements</h5>';
			$html .= '<ul class="supplementFeatured">';
			foreach ($supplements->featured() as $featured) {
					$html .= '<li><a href="'.$featured->directLink.'">'.$featured->ProductName.'</a></li>';
			}
			
			$html .= '</ul>';
			
			$html .= "<h5>Click to see all products</h5>";
			
			$alpha = range('A','Z');
			
			$html .= '<ul class="alphaList">';
			foreach ($alpha as $bet) {
				$html .= '<li class="alpha" sel="'.$bet.'">'.$bet.'</li>';
			}
			$html .= '</ul>';	
			
			echo $html;
		}
		
		
		
		public function supplementPreview() {
			
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