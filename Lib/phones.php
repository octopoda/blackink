<?php 
	require_once('phone.php');
	
	class Phones {
		
		public $user_id;
		public $phones = array();
		public $emergencyContact = array();
		public $emergencyPhones = array();
		
		public function __construct($p_id="") {
			
			if (!empty($p_id)) {
				$this->phonesForUser($p_id);
			} 
		}
	
		
		private function phonesForUser($p_id) {
			global $db;
			
			$result = $db->queryFill("SELECT * FROM phoneForUser WHERE user_id = {$p_id}");
			if ($result != false) {
				foreach ($result as $p) {
					$phone = new Phone($p['phone_id']);
					$this->phones[] = $phone;
				}
			}
		}
	
		
		//Methods for Phone print
		public function printPhones() {
			$html = '';
			
			if (is_array($this->phones)) {
				foreach ($this->phones as $phone) {
					$phone->cleanPhoneType();
					$html .= '<span>' .$phone->phonenumber . " (" . $phone->phone_type . ')</span><br />';	
				}
			} else {
				$phone->cleanPhoneType();
				$html .= '<span>' .$phone->phonenumber . " (" . $phone->phone_type . ')</span><br />';	
			}
			
			return $html;
		}
		
		
		
		public function createPhoneFields() {
			$html = '';
			
			if (!empty($this->phones)) {
			foreach ($this->phones as $phone) {
				$html .= '<div class="phone"><p class="phonesForUsers">
							<label for="phonenumber">Phone</label>
							<script type="text/javascript"> $("#phone_type").val("'. $phone->phone_type .'"); </script>
							<input type="hidden" id="phone_id" name="phone_id[]" value="'.$phone->phone_id.'">
							<select id="phone_type" name="phone_type[]"  class="phoneSelect">
								<option selected="selected" value="HP">Home</option>
								<option value="CP">Cell</option>
								<option value="WK">Work</option>
							</select>
							<input id="phonenumber" name="phonenumber[]" placeholder="e.g. (351)215-5555" type="tel" value="'. $phone->phonenumber .'" class="usPhone"  />
						</p></div>';
			}
			} else {
				$html .= '<div class="phone"><p class="phonesForUsers">
							<label for="phonenumber">Phone</label>
							<input type="hidden" id="phone_id" name="phone_id[]">
							<select id="phone_type" name="phone_type[]"  class="phoneSelect">
								<option selected="selected" value="HP">Home</option>
								<option value="CP">Cell</option>
								<option value="WK">Work</option>
							</select>
							<input id="phonenumber" name="phonenumber[]" placeholder="e.g. (351)215-5555" type="tel" class="usPhone"  />
						</p></div>';	
			}
			
			return $html;
		}	
		
		
		
		//Save
		public static function save ($post, $id) {
			global $db; 
			
			$count = count ($post['phonenumber']);
			
			for ($j = 0; $j < $count; $j++) {
				$phone = new Phone();
				$phone->phone_type = $db->escapeString($post['phone_type'][$j]);
				$phone->phonenumber = $db->escapeString($post['phonenumber'][$j]);
				isset($post['phone_id']) ? $phone->phone_id = $db->escapeString($post['phone_id'][$j]) : $phone->phone_id = null;	
				$phone->phone_id = $phone->save($phone->phone_id);
				$phone->updatePhone($id); 
			}
		}
		
		//Delete 
		public static function deleteFromForm($phone_id) {
			global $db;
			
			foreach ($phone_id as $phone) {
				$phone = new Phone($phone);
				$phone->deleteFromForm();	
			}
			
			
		}
		
		
		
	}


?>