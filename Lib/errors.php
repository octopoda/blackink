<?php 

	class Errors {
		private $indicator;
		public $text = array();
		public $errorCount;
		public $function;
		
		
		public function addError($string, $id="") {
			$_SESSION['errors'][] = $string;
			$_SESSION['indicator'] = 1;
			if (!empty($id)) $_SESSION['error_id'] = $id;
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
		 
		 
		public function displayError() {
			//Error
			if (isset($_SESSION['indicator']) && $_SESSION['indicator'] == 1) {
				echo json_encode(array (
					"style" => 'error',
					"text" => $this->setupErrors(),
					"reportError" => true
				));	
			
			
			//Message
			} else if (isset($_SESSION['indicator']) && $_SESSION['indicator'] == 2) {
				echo json_encode(array (
					"style"=> 'message',
					"text"=> $this->setupErrors(),
					"reportError" => false
				));
			}
		}
		
		public function reportError() {
			global $db;
			global $error;
			
			//Setup Mailer
			$mail = new PHPMailer(true);
			$mail->IsSMTP();
			$mail->Host = EMAIL_HOST;
			$mail->Username = REPORT_USER;
			$mail->Password = REPORT_PASS;
			$mail->port = EMAIL_PORT;
			$mail->SMTPAuth   = true;
				
				
			usleep(1000);
			
			$site = new Site();
			
			$users = new Users($_SESSION['user_id']);	
			$toName = $users->printName(); 
			$email = $users->email;
			
			if (!empty($_SESSION['error_id'])) $adminId = $_SESSION['error_id'];
				
			usleep(1000);
			
			if (empty($message) && empty($adminId)) {
				$error->addError("There seems to be no error to report.", 'ER1254');
				return;
			}
					
			$subject = "Error Report from Black Ink and " . $site->siteName;
					
			$mailMessage =  
			'<p>'. $toName . " is having issues with the registration system.</p>
									
			<p>The admin id given is: <br />
			". $adminId ."</p>
									
			
			<p>Their email is: <br />
			" . $email . "</p>
									
			<p>Thanks, 
			Me</p>";
					
			$mail->SMTPDebug  = 1;	
			$mail->AddReplyTo($email, $toName);
			$mail->AddAddress('zack@2721west.com', 'Black Ink Error');
			$mail->SetFrom($email, $toName );
			$mail->Subject = $subject;
			$mail->Body = $mailMessage;
			
			$sent = $mail->Send();
			 
			
			//Mail Sent Change Password
			if ($sent) 
				$error->addError("Your mail has been sent, an admin will return an email to you shortly.", '');
			else
				$error->addError("There seems to be a problem with the server sending an email. Please try again later.", '');
					
			return;	
		}
		
		
		
		
	 }
	 
	 $error = new Errors();
	 
?>