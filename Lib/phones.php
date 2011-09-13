<?php 
	require_once('phone.php');
	require_once('emergencyContact.php');
	
	class Phones {
		
		public $phones = array();
		public $emergencyContact = array();
		public $emergencyPhones = array();
		public $type;
		
		public function __construct($p_id="", $objectName) {
			$this->type = $objectName;
			switch($objectName) {
				case "camper":
					$this->phonesForCamper($p_id);
					$this->emergencyContacts($p_id);
					break;
				case "church":
					$this->phonesForChurch($p_id);
					break;
				case "users":
					$this->phonesForUser($p_id);
					break;
				case "emergency":
					$this->emergencyContacts($p_id);
					break;	
			}
		}
	
		private function phonesForCamper($p_id) {
			global $db;
			
			$result = $db->queryFill("SELECT * FROM phonesForCampers WHERE camper_id = {$p_id}");
			
			if ($result != false) {
				foreach ($result as $p) {
					$phone = new Phone($p['phone_id']);
					$this->phones[] = $phone;	
				}
			}
		}
		
		private function phonesForChurch($p_id) {
			global $db;
			
			$result = $db->queryFill("SELECT * FROM phonesForChurch WHERE church_id = {$p_id}");
			if ($result != false) {
				foreach ($result as $p) {
					$phone = new Phone($p['phone_id']);
					$this->phones[] = $phone;	
				}
			}
		}
		
		private function phonesForUser($p_id) {
			global $db;
			$result = $db->queryFill("SELECT * FROM phonesForUsers WHERE user_id = {$p_id}");
			if ($result != false) {
				foreach ($result as $p) {
					$phone = new Phone($p['phone_id']);
					$this->phones[] = $phone;
				}
			}
		}
	
		private function emergencyContacts($c_id) {
			global $db;
			
			$result = $db->queryFill("SELECT * FROM emergencyContact WHERE camper_id = {$c_id} ORDER BY priority ASC");
			if ($result != false) {
				
				foreach ($result as $e) {
					$emerg = EmergencyContact::emergencyContactByPhone($e['phone_id']);
					$emerg = array_shift($emerg);
					$this->emergencyContact[] = $emerg;	
					$phones = $db->queryFill('SELECT * FROM phone WHERE phone_id = ' . $emerg->phone_id );
					
					foreach ($phones as $p) {
						$phone = new Phone($p['phone_id']);
						$this->emergencyPhones[] = $phone;
					}
					
					
				}
			}
			
	
		}
		
		//Methods for Phone print
		public function printPhones($phoneArray) {
			$html = '';
			
			if (is_array($phoneArray)) {
				foreach ($phoneArray as $phone) {
					$phone->cleanPhoneType();
					$html .= '<span>' .$phone->phonenumber . " (" . $phone->phone_type . ')</span><br />';	
				}
			} else {
				$phone->cleanPhoneType();
				$html .= '<span>' .$phone->phonenumber . " (" . $phone->phone_type . ')</span><br />';	
			}
			
			return $html;
		}
		
		//Methods Print Contact Names
		public function printContactInfo($contactArray) {
			
			$html = '';
			
			foreach ($contactArray as $contact) {
				$phone = new Phone($contact->phone_id);
				$phone->cleanPhoneType();
				
				$html .= '<p>';
				$html .= '<dd>Contact Name:</dd>';
				$html .= '<span>' . $contact->contactName . '</span><br />';
				$html .= '<p>';	
				
				$html .= '<p>';
				$html .= '<dd>Contact Phone:</dd>';
				$html .= '<span>' . $phone->phonenumber . '('. $phone->phone_type .')</span><br />';
				$html .= '<p>';	
			}
			
			return $html;
		}
		
		public function printContactInfoTable($contactArray) {
			
			$html = '';
			
			foreach ($contactArray as $contact) {
				$phone = new Phone($contact->phone_id);
				$phone->cleanPhoneType();
				
				$html .= '<tr>';
				$html .= '<td>Contact Name:</td>';
				$html .= '<td>' . $contact->contactName . '</td>';
				$html .= '<tr>';	
				
				$html .= '<tr>';
				$html .= '<td>Contact Phone:</td>';
				$html .= '<td>' . $phone->phonenumber . '('. $phone->phone_type .')</td>';
				$html .= '<tr>';	
			}
			
			return $html;
		}
		
		
		//Methods for Forms
		public function createPhoneFields() {
			$html = '';
			
			$count = count($this->phones);
			if ($count >= 1) {
				foreach($this->phones as $phone) {
					$html .= '<div class="phone"><p class="phonesForCampers">
								<label for="phonenumber">Phone</label>
								<script type="text/javascript"> $("#phone_type").val("'. $phone->phone_type .'"); </script>
								<input type="hidden" id="phone_id" name="phone_id[]" value="'.$phone->phone_id.'">
								<select id="phone_type" name="phone_type[]"  class="phoneSelect">
									<option selected="selected" value="HP">Home</option>
									<option value="CP">Cell</option>
									<option value="WK">Work</option>
								</select>
								<input id="phonenumber" name="phonenumber[]" placeholder="e.g. (351)215-5555" type="tel" value="'. $phone->phonenumber .'" class="usPhone"  />
								<span class="phoneButtons"><a href="#" class="formAddPhone">Add </a> / <a href="#" class="formDeletePhone"> Delete </a></span>
								 
							</p></div>';
				}
			}else {
				$html .= '<div class="phone"><p class="phonesForCampers">
								<label for="phonenumber">Phone</label>
								<input type="hidden" id="phone_id" name="phone_id">
								<select id="phone_type" name="phone_type"  class="phoneSelect">
									<option selected="selected" value="HP">Home</option>
									<option value="CP">Cell</option>
									<option value="WK">Work</option>
								</select>
								<input id="phonenumber" name="phonenumber" placeholder="e.g. (351)215-5555" type="tel" class="usPhone"  />
								 <span class="phoneButtons"><a href="#" class="formAddPhone">Add </a></span>
							</p></div>';
				
			}
			
			return $html;
		}
		
		
		public function createUserPhoneFields() {
			$html = '';
			
			foreach ($this->phones as $phone) {
				$html .= '<div class="phone"><p class="phonesForUsers">
							<label for="u_phonenumber">Phone</label>
							<script type="text/javascript"> $("#phone_type").val("'. $phone->phone_type .'"); </script>
							<input type="hidden" id="u_phone_id" name="u_phone_id[]" value="'.$phone->phone_id.'">
							<select id="u_phone_type" name="u_phone_type[]"  class="phoneSelect">
								<option selected="selected" value="HP">Home</option>
								<option value="CP">Cell</option>
								<option value="WK">Work</option>
							</select>
							<input id="u_phonenumber" name="u_phonenumber[]" placeholder="e.g. (351)215-5555" type="tel" value="'. $phone->phonenumber .'" class="usPhone"  />
						</p></div>';
			}
			
			return $html;
		}	
		
		
		public function createEmergencyFields() {
			$count = count($this->emergencyContact);
			
			$html = '';
			
			if ($count >= 1) {
				for ($i = 0; $i < $count; $i++) {
					$contact = $this->emergencyContact[$i];
					$phones = $this->emergencyPhones[$i];
					
					$html .= '<div id="emergencyContact">
								<p>
									<label for="contactName">Emergency Contact</label>
									<input id="contactName" name="contactName[]" type="text" value="'. $contact->contactName .'"  />
								</p>
								<p>	
									<script type="text/javascript"> $("#e_Phone_Type").val("'. $phones->phone_type .'"); </script>
									<label for="e_Phone">Emergency Phone</label>
									<input type="hidden" id="e_phone_id" name="e_phone_id[]" value="'.$phones->phone_id.'">
									<select id="e_Phone_Type" name="e_Phone_Type[]" class="phoneSelect" >
										<option selected="selected" value="HP">Home</option>
										<option value="CP">Cell</option>
										<option class="WK">Work</option>
									</select>
									<input id="e_Phone" name="e_Phone[]" placeholder="e.g. (351)215-5555" type="tel" value="'. $phones->phonenumber. '" class="usPhone"  />
								</p>
							</div>';	
				} 
			} else {
				$html .= '<div id="emergencyContact">
								<p>
									<label for="contactName">Emergency Contact</label>
									<input id="contactName" name="contactName[]" type="text" value=""  />
								</p>
								<p>	
									<label for="e_Phone">Emergency Phone</label>
									<select id="e_Phone_Type" name="e_Phone_Type[]" class="phoneSelect" >
										<option selected="selected" value="HP">Home</option>
										<option value="CP">Cell</option>
										<option class="WK">Work</option>
									</select>
									<input id="e_Phone" name="e_Phone[]" placeholder="e.g. (351)215-5555" type="tel" value="" class="usPhone"  />
								</p>
							</div>';
			}
			return $html;
		}
	
		//Save
		public static function save ($post, $id, $name) {
			global $db; 
			
			//For emergecy Contact Information
			if ($name == "emergency") {
				$count = count($post['contactName']); 
				
				for ($i = 0; $i < $count; $i++) {
					$emerg = new EmergencyContact();
					$phone = new Phone();
					
					$phone->phonenumber = $db->escapeString($post['e_Phone'][$i]);
					$phone->phone_type = $db->escapeString($post['e_Phone_Type'][$i]);
					isset($post['e_phone_id']) ? $phone->phone_id = $db->escapeString($post['e_phone_id'][$i]) : $phone->phone_id = null;	
					
					$phone->phone_id = $phone->save($phone->phone_id);
					
					$emerg->contactName = $db->escapeString($post['contactName'][$i]);
					$emerg->camper_id = $id;
					$emerg->phone_id = $phone->phone_id;
					$emerg->priority = $i;
					
					if ($emerg->checkExisiting($emerg->camper_id, $emerg->phone_id)) {
						$emerg->update($emerg->camper_id, $emerg->phone_id);		
					} else {
						$emerg->create();
					}
				} 
			//Church Phone Numbers -- Churches are only allowed one phone number
			} else if ($name == "church") { 
				$count = count($post['phonenumber']);
					
				$phone = new Phone();
				$phone->phone_type = $db->escapeString($post['phone_type']);
				$phone->phonenumber = $db->escapeString($post['phonenumber']);
				isset($post['phone_id']) ? $phone->phone_id = $db->escapeString($post['phone_id']) : $phone->phone_id = null;	
				$phone->phone_id = $phone->save($phone->phone_id);
				
				$result_set = $db->queryFill("SELECT * FROM phonesForChurch WHERE church_id = {$id}");
				if ($result_set != false) {
					//Update
					foreach($result_set as $r) {
						if ($r['phone_id'] = $r['church_id']) {
							$db->query("DELETE FROM phonesForChurch WHERE church_id = {$id}");
							$phone->updatePhone('church', $id);	
						} else {
							$phone->updatePhone('church', $id);	
						}
					}
				} else {
					//Insert	
					$phone->updatePhone('church', $id);
				}
				
				
				
			
			//User Phone Numbers
			} else if ($name == "users") {
				$count = count ($post['u_phonenumber']);
				
				for ($j = 0; $j < $count; $j++) {
					$phone = new Phone();
					$phone->phone_type = $db->escapeString($post['u_phone_type'][$j]);
					$phone->phonenumber = $db->escapeString($post['u_phonenumber'][$j]);
					isset($post['u_phone_id']) ? $phone->phone_id = $db->escapeString($post['u_phone_id'][$j]) : $phone->phone_id = null;	
					$phone->phone_id = $phone->save($phone->phone_id);
					$phone->updatePhone('user', $id); 
				}
			
			//Camper phoneNumbers	
			}else if ($name == "camper"){
				$count = count ($post['phonenumber']);
				
				for ($j = 0; $j < $count; $j++) {
					$phone = new Phone();
					$phone->phone_type = $db->escapeString($post['phone_type'][$j]);
					$phone->phonenumber = $db->escapeString($post['phonenumber'][$j]);
					isset($post['phone_id']) ? $phone->phone_id = $db->escapeString($post['phone_id'][$j]) : $phone->phone_id = null;
					$phone->phone_id = $phone->save($phone->phone_id);
					$phone->updatePhone('camper', $id); 
				}
			}
		}
		
		
		
	}


?>