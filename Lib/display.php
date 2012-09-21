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
		public $scripts = array();



		//Public Attributes
		public $companyAddress;
		public $companyPhones = array();
		public $orderby;
		public $rate;


		public function navigationHandler($urlTitle="", $contentTitle="") {
			if ($urlTitle == NULL) $urlTitle = $this->navTitle;

			$this->navTitle = str_replace("/", "", $urlTitle);
			$this->contentTitle = str_replace("/", "", $contentTitle);


			//echo 'navTitle='.$this->navTitle.'<br />';
			//echo 'contentTitle='.$this->contentTitle.'<br />';

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

		public function addScript($url) {
			$this->scripts[] = $url;
		}


		public function printScripts() {
			$html = "";
			if ($this->scripts == false) {
				return;
			}

			foreach ($this->scripts as $script) {
				$html .= '<script src="'.$script.'"></script>';
			}
			echo  $html;
		}





/*  ===========================================
	SEO Methods
	========================================= */

		public function displayPageTitle() {
			$spacer = " - ";
			if ($this->contentTitle != NULL) {
				return $spacer . $this->content->title;
			} else if (($this->contentTitle == NULL) && ($this->navTitle != NULL)) {
				return $spacer . $this->content->title;
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

				if ($this->user_access >= $list->access && $list->published == 1)
				 	$html .= $list->buildNavigation();
				else
					continue;
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


		public function  paginateClass($classname, $pageNumber, $orderby, $rate) {
				$class = new $classname();
				$html = "";

				$totalSize = count($class->fetchAll());

				$page = 1;
				$size = 10;

				if (isset($pageNumber)) $page = $pageNumber;

				$pagination = new Pagination($classname);
				$pagination->setupPagination($page, $size, $totalSize);
				$result = $class->fetchPublished($orderby, $rate, $pagination->getLimitSQL());

				foreach ($result as $content) {
					$c = new $classname($content[$class->idfield]);
					$html .= $this->buildPaginationHTML($c);
				}

				echo $html;
				echo $pagination->create_links();
		}



		public function buildPaginationHTML($object) {
				$html ="<div>";
				$html .= '<h3><a href="'.$object->directLink.'">'.$object->title.'</a></h3>';
				$html .= '<p>'.  truncate($object->searchable, 400," ", "...").'</p>';
				$html .= '</div>';

				return $html;
		}



/*  ===========================================
	Content Methods
	========================================= */

		private function contentRequest($classname) {
			$class = new $classname();
			$id = $class->idFromLink($this->contentTitle);
			$this->content = new $class($id);


			if ($this->content->content == false) {
				redirect('/404.html');
			}


		}

		private function navigationRequest() {
			if ((!empty($this->navTitle)) && (empty($this->contentTitle))) {
				$this->content = new Content(Navigation::contentIdFromDirectLink($this->navTitle));
			} else if ((!empty($this->navTitle)) && (!empty($this->contentTitle))){
				$this->content = new Content(Navigation::contentIdFromDirectLink($this->contentTitle));
			} else if (empty($this->navTitle) && (empty($this->contentTitle))) {
				$this->content = new Content(Navigation::defaultNavigation());
			}


			if ($this->content->content == false) {
				redirect('/404.html');
			}
		}




		public function displayTitle() {
			echo $this->content->title;
		}

		public function displayContent() {
			if ($this->content->access <= $this->user->access) {
				$module = new ModuleDecoder($this->content->content);


				if ($module != false) {
					echo $module->final;
				} else {
					echo $this->content->content;
				}


			} else {
				echo  '<h3>You do not have the rights to access this page.</h3>';
			}
		}






/*  ===========================================
	Social Methods
	========================================= */

	public function socialIcons() {
		$social = new Social();

		$icons = $social->buildSocialArray();

		$html = "<ul>";
		foreach($icons as $k=>$v) {
			if ($v) {
				$html .= '<li><a target="_blank" class=" social '.$k.'" href="'.$v.'"></a></li>';
			}
		}
		$html .= '<li><a target="_blank" class="social" href="http://feeds.feedburner.com/TheAudioGuy">r</a></li>';
		$html .= "</ul>";
		echo $html;
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
	Helper Methods
	========================================== */


	} //end class
?>