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
