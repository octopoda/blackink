<?php
   	require_once("databaseObject.php");
	
    class contactInformation extends databaseObject{
        
        public $table = "contactInformation";
        public $idfield = "contact_id";
        
        public $contact_id;
		public $email;
		public $address_id;
		public $phonenumber;
		public $faxnumber;
		public $summary; 
		
        public function __construct() {
            $result = $this->fetchById(1);
			$this->address = new Address($this->address_id); 
        }
		
		
		public function createFromForm($post) {
			global $error;
			
			$this->fillFromForm($post);
			
			$address = new Address();
			$address->fillFromForm($post);
			$this->address_id = $address->save($address->address_id);
			
			if ($this->save($this->contact_id)) {
				$error->addMessage('Your Contact Information has been saved');	
				return true;	
			} else {
				$error->addError('The information did not save.', 'Contact1248');
				return false;	
			}
			
			
		}
		
		
		public function emailCompany($post) {
			global $db;
			$site = new Site();
			
			usleep(1000);
			$email = $db->escapeString($post['email']);
			$name = $db->escapeString($post['name']);
			$subject = $db->escapeString($post['subject']);
			$message = $_POST['message'];
			
			$mailMessage =  $message;
			
			
			$mail = new PHPMailer(true);
			$mail->IsSMTP();
			
			$mail->Host = EMAIL_HOST;
			$mail->Username = EMAIL_USER;
			$mail->Password = EMAIL_PASS;
			$mail->Port = 26;
			$mail->SMTPAuth   = true; 
			
			
			$mail->SMTPDebug  = 1;  
			$mail->AddReplyTo($email, $name);
			$mail->AddAddress(EMAIL_USER, $site->siteName." website request");
			$mail->SetFrom($email, $name);
			$mail->Subject = $subject;
			$mail->Body = $mailMessage;
			
			$sent = $mail->Send();
			
			//Mail Sent Change Password
			if ($sent) {
				return true;
			} else {
				return false;
			}
		
		}
		
		
		
	}
?>
