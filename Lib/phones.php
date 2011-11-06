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
			$html = '<ul class="listPhones">';
			
			if (is_array($this->phones)) {
				foreach ($this->phones as $phone) {
					$phone->cleanPhoneType();
					$html .= '<li sel="'.$phone->phone_id.'">' .$phone->phonenumber . " (" . $phone->phone_type . ')</li>';	
				}
			} else {
				$phone->cleanPhoneType();
				$html .= '<li sel="'.$phone->phone_id.'">' .$phone->phonenumber . " (" . $phone->phone_type . ')</li>';	
			}
			$html .= '</ul>';
			return $html;
		}
		
		private function createSelectBox($phone="") {
			global $db;
			
			$result_set = $db->queryFill("SELECT * FROM phoneType");
			$html = '<select id="phone_type" name="phone_type[]"  class="phoneSelect">';
			if ($result_set != false) {
				foreach ($result_set as $row) {
					$html .= '<option ';
					if ((!empty($phone)) && ($phone->phone_type == $row['phone_type']))
						$html .= 'selected="selected" ';
					$html .= 'value="'.$row['phone_type'].'">'.$row['name'].'</option>';
				}
			}
			$html .= '</select>'; 	
			
			return $html;
		}
		
		
		static function addPhone() {
			$phones = new Phones(); 
			$html = '<p class="phonesForUsers">
							<label for="phonenumber">Phone</label>
							<input type="hidden" id="phone_id" name="phone_id[]">';
			$html .=  $phones->createSelectBox(); 				
			$html .= '<input id="phonenumber" name="phonenumber[]" placeholder="e.g. (351)215-5555" type="tel" class="usPhone"  /> <span class="phoneButtons"><a href="#" class="addPhone"> + Add Phone </a>
						</p>';	
						
			return $html;
		}
		
		
		public function createPhoneFields() {
			$html = '';
			$count = count($this->phones);
			$nTimes = 1;
			if (!empty($this->phones)) {
				$html .= '<div class="phone">';
				foreach ($this->phones as $phone) {
						$html .= '<p class="phonesForUsers">
							<label for="phonenumber">Phone</label>
							<input type="hidden" id="phone_id" name="phone_id[]" value="'.$phone->phone_id.'">';
						$html .= $this->createSelectBox($phone);	
						$html .= '<input id="phonenumber" name="phonenumber[]" placeholder="e.g. (351)215-5555" type="tel" value="'. $phone->phonenumber .'" class="usPhone"  />';
							if ($nTimes == $count) {
								$html .= '<span class="phoneButtons"><a href="#" class="addPhone">+ Add Phone </a></p>';
							}
						$nTimes++;	
				}
				$html .= '</div>';
			} else {
				$html .= '<div class="phone"><p class="phonesForUsers">
							<label for="phonenumber">Phone</label>
							<input type="hidden" id="phone_id" name="phone_id[]">';
				$html .=  $this->createSelectBox();			
				$html .= '<input id="phonenumber" name="phonenumber[]" placeholder="e.g. (351)215-5555" type="tel" class="usPhone"  />
							<span class="phoneButtons"><a href="#" class="addPhone"> + Add Phone </a>
						</p></div>';	
			}
			
			return $html;
		}	
		
		
		
		//Save
		public static function save ($post, $id) {
			global $db; 
			
			$count = count($post['phonenumber']);
			
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