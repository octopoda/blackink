<?php
    // CREATED 1/5/11 - MCJ
    
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
  
        public function __construct($u_id="") {
           if (empty($u_id) && !isset($_SESSION['user_id']))  {
                return false;
            } else if (empty($u_id) && isset($_SESSION['user_id'])) {
                $this->setUser($_SESSION['user_id']);    
            } else if (isset($u_id)) {
                $this->setUser($u_id);    
            }
        }
    
        private function setUser($u_id) {
            global $db;
            
            $result = $db->queryFill("SELECT * FROM users WHERE user_id= {$u_id} LIMIT 1");

            if ($result != false)
            {
                $result = array_shift($result);
                $this->instantiate($result, $this);
                if (isset($this->user_id)) {
                    $this->getAccess();
					$this->loggedIn = true;
                }
            }
        }

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
   
   		public function printName () {
            return $this->first." ".$this->last;
		}
        
        public function isLoggedIn() {
            return $this->loggedIn;
        }
        
        public function LogOut() {
            $this->loggedIn = false;
        }
        
       
		// return true if the name is OK to use, or false if it's already been used
        private function checkUsername($checkThis) {
            $result = $this->findByKey('email', $this->escapeString($checkThis));
            if ($result == false) return true;
            return false;
        }
		
		
		
		public function createUserFromForm($post) {
			
		}
        
        public function saveForForm() {
            if (strlen($this->password) != 32) $this->password = md5($this->password);
            return $this->user_id = $this->save($this->user_id);
        }   
		 
		public function changePassword($pw_1, $pw_2) {
			global $error;
			
			if (md5($pw_1) == $this->password) {
				$this->password = md5($pw_2); 
				$this->saveForForm();
			} else {
				echo "Your original password did not match our records";
				return false;	
			}
			
			return true;
		}
		
		public function getUserById($id) {
			return $this->fetchById($id);	
		}
		
		
/* =======================================
	Access Functions
   ===================================== */
		
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
		
		
/* =======================================
	Admin Functions
   ===================================== */
   
 	  public function pagination ($offset, $rowsPerPage) {
			return "SELECT U.email, UG.group_id, U.company, U.NPINumber FROM users U JOIN userInGroups UG ON U.user_id = UG.user_id LIMIT {$offset}, {$rowsPerPage}";   
   	  }
	  
	  
} // </Class>
	
	

?>
