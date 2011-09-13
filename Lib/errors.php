<?php 

	class Errors {
		
		public function addError($string) {
			$_SESSION['errors'][] = $string;
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
		 
		 
		public function displayErrors() {
			$count = count($_SESSION['errors']);
			
			$html = '<div id="errorWrapper">	
						<a class="errorClose">Close</a>
						<p class="errorMessage">';
			
			if ($count > 1) {
				for($i = 0; $i < $count; $i++) {
					$html .= '<span>' . $_SESSION['errors'][$i] . '</span>';	
				}
				
				
			} else  if ($count == 1){
				$html .= '<span>'. $_SESSION['errors'][0] .'</span>';	
			}
			
			$html .= '</p>
					<a class="reportError">Report Error</a>
				</div>';
			return $html;
		}
		
		
	 }
	 
	 $error = new Errors();
	 
?>