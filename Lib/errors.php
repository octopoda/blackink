<?php 

	class Errors {
		private $indicator;
		public $text = array();
		public $errorCount;
		public $function;
		
		
		public function addError($string) {
			$_SESSION['errors'][] = $string;
			$_SESSION['indicator'] = 1;
		}
		
		public function addMessage($string) {
			$_SESSION['errors'][] = $string;
			$_SESSION['indicator'] = 2;
		}
		
		public function errorsLoaded() {
			if (empty($_SESSION['errors'])) {
				return false;
			} else {
				return true;	
			}
		}
		 
		public function clearErrors() {
			unset($_SESSION['errors']);
			$_SESSION['errors'] = array();
			return true;
		}
		
		private function setupErrors() {
			$html = '<ul>';
			
			foreach ($_SESSION['errors'] as $text) {
				$html .= '<li>'. $text.'</li>';
			}
			
			return $html .= '</ul>';
		}
		 
		 
		public function displayErrors() {
			if (isset($_SESSION['indicator']) && $_SESSION['indicator'] == 1) {
				$this->function = 'modalError("'.$this->setupErrors().'")';
			} else if (isset($_SESSION['indicator']) && $_SESSION['indicator'] == 2) {
				$this->function = 'modalMessage("'.$this->setupErrors().'")';
			}
			
			
			$html = '<script type="text/javascript">'. $this->function .';</script>';
			return $html;
		}
		
		
		
		
	 }
	 
	 $error = new Errors();
	 
?>