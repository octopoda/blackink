<?php
   	require_once("databaseObject.php");


    //Class and Table need to be the same name
    class Users extends databaseObject{

        public $table = "users";
        public $idfield = "user_id";
        public $user_id;
        public $first;
        public $last;
        public $password;
        public $email;
		public $loggedIn = false;
		public $guid;
		public $company;
		public $last_login;
		public $created_on;
		public $prev_login;

		//Helpers
		public $access;
		public $address_id;
		public $phone_id = array();

		public $salt;



        public function __construct($u_id="") {

			if (!empty($u_id)) {
				$this->user_id = $u_id;
				$this->setUser($u_id);
			} else {
				$this->access = 1;
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
					//$this->getAddress();
					//$this->getPhone();
					$this->loggedIn = true;
                }
            }
        }

		public function printName () {
            return $this->first." ".$this->last;
		}

		private function getAccess() {
			global $db;

			$sql = "SELECT  UG.position FROM userInGroups G INNER JOIN userGroups UG ON G.group_id = UG.group_id WHERE G.user_id  = {$this->user_id} LIMIT 1";
			$result_set = $db->queryFill($sql);

			if ($result_set != false) {
				foreach($result_set as $row) {
					$this->access = $row['position'];
				}
			}
		}


		private function getAddress() {
			global $db;
			global $error;

			$result_set = $db->queryFill("SELECT address_id FROM addressForUser WHERE user_id = {$this->user_id}");
			if ($result_set != false) {
				foreach ($result_set as $row) {
					$this->address_id = $row['address_id'];
				}
			} else {
				$error->addMessage('This user has no address entered in the database.', 'User5746');
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
				$error->addMessage('This user has no phone entered in the database.', 'User9876');
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
                $result = $db->queryFill('SELECT users.password, userSalts.salt, users.user_id FROM users INNER JOIN userSalts ON users.user_id = userSalts.user_id WHERE email = "'.$db->escapeString(strtolower($email)).'" LIMIT 1');
                if ($result != false) {
                    $result = array_shift($result);
                    $this->instantiate($result, $this);
                    $this->salt = $result['salt'];

                    if ($this->hashWithSalt($pass, $this->salt) == $this->password) {
                        if (isset($this->user_id)) {
                            $this->loggedIn = true;
                            $_SESSION['user_id'] = $this->user_id;      // set this so we can auto-recreate later on
							$this->updateDate();
                           return true;
                        }
                    }
                }
            }

            return false;
		}

		private function  hashWithSalt($hash, $salt) {
			return sha1('Black ' . $salt .'Ink hashes'. $hash);
		}

		private function makeSalt() {
			return sha1(time().rand());
		}

		private function getSalt() {
			global $db;
			$result = $db->queryFill("SELECT salt FROM userSalts WHERE user_id = {$this->user_id} LIMIT 1");
			$result = array_shift($result);
			return $result['salt'];
		}


		public function isLoggedIn() {
            return $this->loggedIn;
        }

        public function LogOut() {
            $this->loggedIn = false;
        }

		private function updateDate() {
			global $db;
			$last = date('Y-m-d H:i:s');

			if ($this->last_login != false) {
				$last = $this->last_login;
			}

			$date = date('Y-m-d H:i:s');

			$db->query("UPDATE users SET last_login = '{$date}', prev_login = '{$last}'  WHERE user_id = '{$this->user_id}'");
		}

		public static function checkAccess($accessNeeded, $user_id) {
			global $db;

			$user = new Users($user_id);
			$accessId = 0;

			$result = $db->queryFill("SELECT group_id FROM userGroups WHERE groupname = '{$accessNeeded}'");
			if ($result != false) {
				foreach ($result as $row) {
					$accessId = $row['group_id'];
				}
			}


			if ($user->access >= $accessId) {
				return true;
			} else {
				return false;
			}
		}


/* =======================================
	Registration Methods
   ===================================== */

		 public function checkUsername($checkThis) {
		 	global $db;
            $result = $this->fetchByKey('email', $db->escapeString($checkThis));
           	if ($result == false) return true;
            return false;
        }



 /* =======================================
	CRUD Methods
   ===================================== */
		public function createUserFromForm($post) {
			global $error;
			global $db;

			//Create User return ID
			$this->fillFromForm($post);

			if (!empty($post['password'])) {
				$this->salt = $this->makeSalt();
				$this->password = $this->hashWithSalt($post['password'], $this->salt);
			}

			if (empty($this->guid)) {
				$this->guid = uniqid('', true);

			}

			if (empty($this->created_on)) {
				$this->created_on = date("Y-m-d H:i:s");
			}


			$u_id = $this->save($this->user_id);

			//Save Salt
			$db->query("INSERT INTO userSalts (user_id, salt) VALUES ({$u_id}, '{$this->salt}')");

			//Create Address return ID
			// $address = new Address();
			// $address->fillFromForm($post);
			// $a_id= $address->save($address->address_id);
			// $saveAddress = new Address($a_id);
			// $saveAddress->addAddressToUser($u_id);


			//Create Phone return ID
			//Phones::save($post,  $u_id);

			$saveUser = new Users($u_id);

				//Set Access to Registered
			if (!isset($saveUser->access)) {
				$this->setAccess($_POST['access'], $u_id);
			}

			if ($u_id == NULL) {
				$error->addError("The user was not created.", 'User10974');
			} else {
				return $u_id;
			}


		}

		public function updateUser($post) {
			$this->fillFromForm($post);

			$u_id = $this->save($this->user_id);

			// //Create Address return ID
			// $address = new Address();
			// $address->fillFromForm($post);
			// $a_id= $address->save($address->address_id);
			// $saveAddress = new Address($a_id);
			// $saveAddress->addAddressToUser($u_id);

			// //Create Phone return ID
			// Phones::save($post,  $u_id);

			if ($u_id == NULL || $a_id == NULL ) {
				$error->addError("The user was not Updated.", 'User10222');
			}

			return $u_id;

		}

		public function deleteFromForm() {
			global $db;

			//Delete Phone
			//Phones::deleteFromForm($this->phone_id);

			//Delete Address
			//$address = new Address($this->address_id);
			//$address->deleteFromForm();

			//Delete User
			$db->query("DELETE FROM userSalts WHERE user_id = {$this->user_id}"); //Delete Salt
			$db->query("DELETE FROM userInGroups WHERE user_id = {$this->user_id}"); //Delete Group
			$this->delete($this->user_id); //Delete User

		}



 /* =======================================
	Change Password Methods
   ===================================== */

		public function changePassword($pw) {
				global $error;

				$salt = $this->getSalt();
				$this->password = $this->hashWithSalt($pw, $salt);
				$this->user_id = $this->save($this->user_id);

				if ($this->user_id == false) {
					$error->addError('Your password was not saved.', 'user1342');
					return false;
				}

				$error->addMessage($this->printName() .'\'s password has been changed.');
				return true;
		}

		public function checkPassword($pw) {
			$salt = $this->getSalt();

			if ($this->hashWithSalt($pw, $salt) != $this->password)
				echo "The Password entered does not match our files.";

		}


		static function forgotPassword($email) {
			global $db;
			global $error;


			$result = $db->queryFill("SELECT * FROM users WHERE email = '{$email}' LIMIT 1");
			$site = new Site();

			if (empty($result)) {
				echo 'Sorry your email is not in our files.  Please feel free to join our site.';
			} else {
				$result = array_shift($result);
				$first =  $result['first'];
				$last = $result['last'];
				$guid = $result['guid'];
			}

			if (empty($err)) {
				usleep(1000);
				$link = 'http://' . $site->siteURL.DS. 'forgot_password.php?g=' . $guid;
				$subject = $site->siteName . " - Forgot password";
				$mailMessage =
					"<p>You requested a new password from ".$site->siteName.".</p>
					 <p>Please click, or copy and paste into your broswer, the following link.  You will be directed to a page in
					 order to change your password. </p>

					 <p><a href=\"".$link ."\"></a>".$link."</p>

					 <p>If you did not request a new password please ignore this email. </p>

					 <p>Thanks,</p>

					 <p>". $site->siteName." Support</p>";



				$mail = new PHPMailer(true);
				$mail->IsSMTP();
				$mail->IsHTML();

				$mail->Host = EMAIL_HOST;
				$mail->Username = EMAIL_USER;
				$mail->Password = EMAIL_PASS;
				$mail->Port = EMAIL_PORT;
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
					echo "An email has been to sent with further instructions.";
				} else {
					echo "There was a problem sending email.  Please try again or contact us.";
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
