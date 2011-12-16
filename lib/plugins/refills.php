<?php
   	require_once(CLASS_PATH.DS."databaseObject.php");
	
    class Refills extends databaseObject{
        
        public $table = "refills";
        public $idfield = "refill_id";
        
        public $refill_id;
		public $name;
		public $email;
		public $phone;
		public $delivery;
		public $number;
		public $special;
		public $content;
		public $time;
		
		//Helper Functions
		public $displayTime;
		public $displayDelivery;

		
        public function __construct($r_id="") {
           if (empty($r_id)) $r_id = $this->refill_id;
			
			if (!empty($r_id)) {
         		$result = $this->fetchById($r_id);
				$this->editTime();
			} 
        }
/* ========================================
	Build/Helper Methods 
	==================================== */	 
		private function editTime() {
			$this->displayTime = date('m/d/Y H:i', $this->time);
		}	
		
		private function displayDeliveryType() {
			if ($this->delivery == 1) {
				$this->displayDelivery = "Pick Up";	
			} else {
				$this->displayDelivery = "Delivery";
			}
		}
	
	
	
		
		
/* ========================================
	Display Methods 
	==================================== */
		
	
		
/* ========================================
	Admin Methods 
	==================================== */
	
	//CRU
	public function createRefillFromForm($post) {
		global $error;
		
		$this->fillFromForm($post);
		
		$this->time = time();
		
		$refill_id = $this->save($this->refill_id);
		
		if (!empty($refill_id)) {
			$this->mailPharmacist();
			return $refill_id;
		} else {
			$error->addError('The information did not save.', 'Refill1284');	
		}
	}
	
	
	
	//Delete
	public function deleteFromForm() {
		global $error;
			
			if ($this->delete($this->refill_id)) {
				return true;
			} else {
				$error->addError('The information did not save.', 'Refill1564');	
			}
	}
	
	
	//Mail Prescitption information
	private function mailPharmacist() {
				$this->displayDeliveryType();
				$this->editTime();
				$contactInformation = new ContactInformation();
				$site = new Site();
				
				$subject = $site->siteName . " - Refill Request";
				$mailMessage =  
					'<p>A online refill has been requested</p>
					 <ul>
					 	<li>Prescription #: '.$this->number.' </li>
						<li>Name: '.$this->name.' </li>
						<li>Delivery Type: '.$this->displayDelivery.' </li>
						<li>Time of Request: '.$this->displayTime.' </li>
					 </ul>
					 
					  <p>'.$this->name.' can be reached by email at '.$this->email.' or by phone at '.$this->phone.'. You can also email '.$this->name.' by replying to this email.</p>
					
					 <p>Thanks,</p>
					 
					 <p>". $site->siteName." Support</p>';			 			

				
				
				$mail = new PHPMailer(true);
				$mail->IsSMTP();
				$mail->IsHTML();
				
				$mail->Host = EMAIL_HOST;
				$mail->Username = EMAIL_USER;
				$mail->Password = EMAIL_PASS;
				$mail->Port = EMAIL_PORT;
				$mail->SMTPAuth   = true; 
				
				$mail->AddReplyTo($this->email);
				$mail->AddAddress($contactInformation->email, 'Innovation Compounding');
				$mail->SetFrom('noreply@'.$site->siteURL, $site->siteName.' - No Reply' );
				$mail->Subject = $subject;
				$mail->Body = $mailMessage;
				
				$sent = $mail->Send();
	}
	
	

/* ========================================
	Redefine Methods 
	==================================== */
	
}// /Class
?>
