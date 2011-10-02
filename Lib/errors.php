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
			unset($_SESSION['indicator']);
			$_SESSION['errors'] = array();
			return true;
		}
		
		private function setupErrors() {
			if (isset($_SESSION['indicator']) && $_SESSION['indicator'] == 1) {
				$html = '<ul class="text">';
				foreach ($_SESSION['errors'] as $text) {
					$html .= '<li>'. $text.'</li>';
				}
				$html .= '</ul>';
			} else if (isset($_SESSION['indicator']) && $_SESSION['indicator'] == 2) {
				$html = '<p class="text">';	
				foreach ($_SESSION['errors'] as $text) {
					$html .=  $text . '    ';
				}
				$html .= "</p>";
			}
			
			return $html;
		}
		 
		 
		public function displayErrors() {
			if (isset($_SESSION['indicator']) && $_SESSION['indicator'] == 1) {
				$this->function = 
				'$("#dialog").modal({ 
						style: \'error\',
						text: \''. $this->setupErrors() .'\',
						reportError: true,
						reportURL: \'forms/report_errors.php\'
					});';
			} else if (isset($_SESSION['indicator']) && $_SESSION['indicator'] == 2) {
				$this->function = '$("#dialog").modal({ 
						style: \'message\',
						text: \''. $this->setupErrors() .'\',
					});';
			}
			
			echo $this->function;
			$html = '<script>'. $this->function .';</script>';
			//echo $html;
		}
		
		
		
		
	 }
	 
	 $error = new Errors();
	 
?>