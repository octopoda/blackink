<?php

	//All Navigation pieces for the Admin 
    class AdminNavigation {
      	public $navigation;
	    public $mainNav = array();
		
		//Create the Main Navigaton
		public function __construct () {
			$this->createMainNavigation();
		}
    
		//List Main Navigation
		public function createMainNavigation() {
			$this->mainNav[] = $this->listNav('Dashboard', 'forms/dashboard.php', 0);
			$this->mainNav[] = $this->listNav('Site', 'forms/site/info_site.php', 0);
			$this->mainNav[] = $this->listNav('Navigation', 'forms/navigation/navigation.php', 0);
			$this->mainNav[] = $this->listNav('Content', 'forms/content/list_content.php', 0);
			$this->mainNav[] = $this->listNav('Users', 'forms/users/list_users.php', 0); 
			$this->mainNav[] = $this->listNav('Media', 'forms/media/media.php', 0);
			//$this->mainNav[] = $this->listNav('Applications', 'forms/applications/', 0); 
			
			return $this->mainNav;	
		}
		
		public function createTabArray($mainNavItem) {
			global $db;
			$tabs = array();
			
			switch ($mainNavItem) {
				case 'Site':
					$tabs[] = $this->listNav('Site Information', 'forms/site/info_site.php', 1);
					$tabs[] = $this->listNav('Contact Information', 'forms/site/info_contact.php', 1);
					break;
					
				case 'Navigation':
					$tabs[] = $this->listNav("Navigation", 'forms/navigation/navigation.php', 1);
					$tabs[] = $this->listNav("Menus", 'forms/navigation/menus.php', 1);
					$tabs[] = $this->listNav('Edit Navigation', 'forms/navigation/form_navigation.php', 1);
					break;
				
				case 'Content':
					$tabs[] = $this->listNav('List Content', 'forms/content/list_content.php', 1);
					$tabs[] = $this->listNav('Edit Content', 'forms/content/form_content.php', 1);
					$tabs[] = $this->listNav('News', 'forms/content/list_news.php', 1);
					$tabs[] = $this->listNav('Advertisments', 'forms/content/list_ads.php', 1);
					break;
					
				case 'Users':
					$tabs[] = $this->listNav('Search Users', 'forms/users/list_users.php', 1);
					$tabs[] = $this->listNav('Edit User', 'forms/users/form_users.php', 1);
					$tabs[] = $this->listNav('Change Password', 'forms/users/change_password.php', 1);
					break;
				
				case 'Media':
					$tabs[] = $this->listNav('Your Media', 'forms/media/media.php', 1);
					$tabs[] = $this->listNav('Upload Media', 'forms/media/upload.php', 1);
					break;
				
				
			}
			
			return $tabs;
		}
		
		
	
		//Display Navigation 
		public function displayMainNavigation() {
			$html = '<ul>';
			$nTimes = 0;
			
			foreach ($this->mainNav as $mainNav) {
				$html .= '<li';
				if ($nTimes == 0) $html .= ' class="active" ';
				$html .= '><a href="'.$mainNav['link'].'" sel="'.$mainNav['title'].'">'.$mainNav['title'].'</a></li>';
				$nTimes++;
			}
			
			$html .= '</ul>';
			
			echo $html;
		}
		
		public function displayTabNavigation($title) {
			$html = '<ul>';
			$nTimes = 0;
			
			foreach ($this->mainNav as $mainNav) {
				if ($mainNav['title'] == $title) {
					foreach ($mainNav['tabs'] as $tabs) {
						$html.= '<li'; 
						if ($nTimes == 0) $html .= ' class="active" ';
							
						$html .= '><a href="'.$tabs['link'].'" sel="'.$tabs['title'].'" >'.$tabs['title'].'</a></li>';
						$nTimes++;	
					}
					
				}
			}
			
			$html .= '</ul>';
			
			return $html;
		}
		
		
		
		//Create Array for Navigations
		private function listNav($title, $link, $main) {
			//$main is 0 
			if ($main == 0) {
				$tabs = $this->createTabArray($title);
				return array('title'=>$title, 'link'=>$link, 'tabs'=>$tabs);	
			} else {
				return array('title'=>$title, 'link'=>$link);
			}
		}
	}
?>
