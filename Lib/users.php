<?php
   	require_once("databaseObject.php");
	
    
    //Class and Table need to be the same name
    class Users extends databaseObject{
        
        public $table = "users";
        public $idfield = "user_id";
        public $allowCache = true;
        public $user_id;
        public $first;
        public $last;
        public $password;
        public $email;
		public $company;
		public $NPINumber;
        public $loggedIn = false;
		public $guid;
		
		//Helpers
		public $access;
		public $address_id;
		public $phone_id = array();
  
        public function __construct($u_id="") {
          	
			if (!empty($u_id)) { 
				
				$this->user_id = $u_id;
				$this->setUser($u_id);
			} else {
				return;	
			}
        }
/* =======================================
	Setup and Helper Methods
   ===================================== */
	    
        private function setUser($u_id) {
            global $db;
        
            $result = $db->queryFill("SELECT * FROM users WHERE user_id= {$u_id} LIMIT 1");

            if ($result != false)
            {
                $result = array_shift($result);
                $this->instantiate($result, $this);
                if (isset($this->user_id)) {
                    $this->getAccess();
					$this->getAddress();
					$this->getPhone();
					$this->loggedIn = true;
                }
            }
        }
		
		public function printName () {
            return $this->first." ".$this->last;
		}
		
		private function getAccess() {
			global $db;
			
			$sql = "SELECT G.group_id, UG.groupname FROM userInGroups G INNER JOIN userGroups UG ON G.group_id = UG.group_id WHERE G.user_id  = {$this->user_id} LIMIT 1";
			$result_set = $db->queryFill($sql);
			
			if ($result_set != false) {
				foreach($result_set as $row) {
					$this->access = $row['group_id'];	
				}
			}
		}
		
		
		private function getAddress() {
			global $db;
			$result_set = $db->queryFill("SELECT address_id FROM addressForUser WHERE user_id = {$this->user_id}");
			if ($result_set != false) {
				foreach ($result_set as $row) {
					$this->address_id = $row['address_id'];
				}	
			} else {
				$error->addError('This user has no address entered in the database.', 'User5746');	
			}
		}
		
		private function getPhone() {
			global $db;
			global $error; 
			
			$result_set = $db->queryFill("SELECT phone_id FROM phoneForUser WHERE user_id = {$this->user_id}");
			if ($result_set != false) {
				foreach ($result_set as $row) {
					$this->phone_id[] = $row['phone_id'];
				}	
			} else {
				$error->addError('This user has no Phone entered in the database.', 'User9876');	
			}
		}
		
		static function getUsersFromGuid($g_id) {
			global $db;
			
			$result_set = $db->queryFill("SELECT user_id FROM users WHERE guid = '{$g_id}'");
			
			if ($result_set != false) {
				foreach ($result_set as $row) {
					return $row['user_id'];	
				}
			} else {
				return false;
			}
		}
		
/* =======================================
	Authentication Methods
   ===================================== */
	
   		public function authenticate($email,$pass) {
            global $db;
            if (!empty($email)) {
                $result = $db->queryFill('SELECT * FROM users WHERE email = "'.$db->escapeString(strtolower($email)).'" LIMIT 1');
                if ($result != false) {
                    $this->instantiate(array_shift($result), $this);
                    if (md5($pass) == $this->password)
                    {
                        if (isset($this->user_id)) {
                            $this->loggedIn = true;
                            $_SESSION['user_id'] = $this->user_id;      // set this so we can auto-recreate later on
                           return true;
                        }
                    }
                }
            }
                
            return false;                
		}
		
		 public function isLoggedIn() {
            return $this->loggedIn;
        }
        
        public function LogOut() {
            $this->loggedIn = false;
        }


/* =======================================
	Registration Methods
   ===================================== */
		
		 private function checkUsername($checkThis) {
            $result = $this->findByKey('email', $this->escapeString($checkThis));
            if ($result == false) return true;
            return false;
        }
   
   		
        
 /* =======================================
	CRUD Methods
   ===================================== */
		public function createUserFromForm($post) {
			global $error;
			
			//Create User return ID
			$this->fillFromForm($post);
			$this->password = md5($this->password);
			$this->guid = uniqid('', true);
			$u_id = $this->save($this->user_id);
			echo $u_id;
			
			//Set Access to Registered
			$this->setAccess($this->access, $u_id);
			
			//Create Address return ID
			$address = new Address();
			$address->fillFromForm($post);
			$a_id= $address->save($address->address_id);
			$saveAddress = new Address($a_id);
			$saveAddress->addAddressToUser($u_id);
			
			//Create Phone return ID
			Phones::save($post,  $u_id);
			
			if ($u_id == NULL || $a_id == NULL ) {
				$error->addError("The user was not created.", 'User10974');	
			}
		}
		
		public function deleteFromForm() {
			global $db;
			
			//Delete Phone
			Phones::deleteFromForm($this->phone_id);
			
			//Delete Address
			$address = new Address($this->address_id);
			$address->deleteFromForm();
			
			//Delete User
			$db->query("DELETE FROM userInGroups WHERE user_id = {$this->user_id}");
			$this->delete($this->user_id);
			
		}
		
		
		
 /* =======================================
	Change Password Methods
   ===================================== */		
   		
		public function changePassword($pw) {
				global $error;
				
				if (strlen($pw) != 32) $this->password = md5($pw);
				
				$this->user_id = $this->save($this->user_id);
				
				if ($this->user_id == false) {
					$error->addError('Your password was not saved.', 'user1342');
					return false;
				}
				$error->addMessage($this->printName() .'\'s password has been changed.');
				return true;
		}
		
		public function checkPassword($pw) {
			if (md5($pw) != $this->password) 
				echo "The Password entered does not match our files.";	
			 
		}
		
		
		public function forgotPassword($email) {
			global $db;
			global $error;
			
			$err = NULL;

			
			$result = $db->queryFill("SELECT * FROM users WHERE email = '{$email}' LIMIT 1");
			$site = new Site();
			
			if (empty($result)) {
				$error->addError("Sorry that email is not on file");
				$err[] = 1;
			} else {
				$result = array_shift($result);
				$first =  $result['first'];
				$last = $result['last'];
				$guid = $result['guid'];
			}
		
			if (empty($err)) {
				usleep(1000);
				$link = 'http://' . $site->siteURL . 'forgot_password.php?gi=' . $guid;	
				$subject = $site->siteName . " - Forgot password";
				$mailMessage =  
					"<p>You requested a new password from ".$site->siteName.".</p>
					 <p>Please click, or copy and paste into your broswer, the following link.  You will be directed to a page in 
					 order to change your password. </p>
					 
					 <p><a href=\"".$link ."\"></a>".$link."</p>  
					
					 <p>Thanks,</p>
					 
					 <p>". $site->siteName." Support</p>";			 			

				
				
				$mail = new PHPMailer(true);
				$mail->IsSMTP();
				
				$mail->Host = EMAIL_HOST;
				$mail->Username = EMAIL_USER;
				$mail->Password = EMAIL_PASS;
				$mail->Port = 25;
				$mail->SMTPAuth   = true; 
				
				
				//$mail->SMTPDebug  = 1;  
				$mail->AddReplyTo('noreply@'.$site->siteURL,  $site->siteName . ' - No Reply');
				$mail->AddAddress($email, $first . $last);
				$mail->SetFrom('noreply@'.$site->siteURL, $site->siteName.' - No Reply' );
				$mail->Subject = $subject;
				$mail->Body = $mailMessage;
				
				$sent = $mail->Send();
				
				//Mail Sent Change Password
				if ($sent) {
					$error->addMessage('An email has been sent to our email on file.');
				} else {
					$error->addError('There was a problem sending to your email address', 'u9875');
				}
				
			}
		}
	
		
		
		


/* =======================================
	Redefine Methods
   ===================================== */
		public function setAccess($newAccess, $id) {
			global $db;
				
			$u = $db->queryFill("SELECT * FROM userInGroups WHERE user_id = {$id}");
			
			if ($u == false) {
				//Insert
				$db->query("INSERT INTO userInGroups (group_id, user_id) VALUES ('{$newAccess}', '{$id}')");	
			} else {
				$result_set = $db->query("UPDATE userInGroups SET group_id = {$newAccess} WHERE user_id = {$id}");
			}
			
			if ($db->affectedRows() > 0)  return true;
		}
	  
} // </Class>
	
	

?>
