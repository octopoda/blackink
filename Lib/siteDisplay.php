<?php 
require_once (CLASS_PATH.DS.'display.php');

class SiteDisplay extends display {
	
	protected $handler = array('content'=>'content', 'ads'=>'ads', 'news'=>'news');
	
	public function __construct($urlTitle="", $contentTitle="") {
		$this->navigationHandler($urlTitle, $contentTitle);	
		$this->setupUser($_SESSION['user_id']);
	}
	
}

?>