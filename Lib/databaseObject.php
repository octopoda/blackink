<?php
    // REQUIRED VARIABLES:
    // - One variable for each field in the table.  Must be the same name.
    // $table - contains the name of the table in the database. Required
    // $idfield - contains the name of the id field in the table.  Required for 'fetchById'
    
require_once("errors.php");

abstract class databaseObject {

/* ================================================	
	Fetch Methods
   ================================================	 */	
		
		public function fetchBySQL($sql="") {
            global $db;
			
			$result_set = $db->queryFill($sql);
			
			$object_array = array();
			
			foreach ($result_set as $row) {
				$object_array[]	= $this->instantiate($row, $this);
			}
			
           return $object_array;
		}
		
        
		public function fetchAll($orderby="") {
            global $db;
			
			if ($orderby != "") $orderby = " ORDER BY ".$orderby;
			$result_array = $db->queryFill("SELECT * FROM " . $this->table . $orderby);
			
			if ($result_array != false) {
				$count = count($result_array);
				
				if ($count == 1) {
					$result_array =  array_shift($result_array); 	
				}
				
				return $result_array;
			} else {
				return false;	
			}
		}
		
		public function fetchById($id = "") {
			if ($id == NULL) $id = 0;
			
			$result_array = $this->fetchBySQL("SELECT * FROM {$this->table} WHERE {$this->idfield}={$this->quoteField($id)} LIMIT 1");
			if ($result_array != false) {
				$result_array = array_shift($result_array);
				return $result_array;
			} 
			
			return false;
			
		}
		
        public function fetchByKey($key,$val,$tbl="") {
            if (empty($tbl)) $tbl = $this->table;
            $result_array = $this->fetchBySQL("SELECT * FROM {$tbl} WHERE {$key} = {$this->quoteField($val)} LIMIT 1");
            return !empty($result_array) ? array_shift($result_array) : false;
        }
		
		public function fetchSingleItem($item, $key, $id,  $tbl="") {
			global $db;
			
			if (empty($tbl)) $tbl = $this->table;
			$result_array = $db->queryFill("SELECT {$item} FROM {$tbl} WHERE {$key} = {$id} ");
			
			return !empty($result_array) ? array_shift($result_array) : false;	
		}
		
		public function arrayShift($array) {
			$count = count($array);
			
			if ($count == 1) {
				$array = array_shift($array);
			}
			
			return $array;
		}
		
/* ================================================	
	Build Methods
   ================================================	 */		
		
		private function getAttribute($record) {
			foreach ($record as $attribute=>$value)	{
				return $attribute;	
			}
		}
        
		public function instantiate($record, $object="") {
			if ($object == NULL) {
               $object = new $this->table;
            }
			
			foreach($record as $attribute=>$value) {
				
				if ($object->hasAttribute($attribute)) {
					$object->$attribute = $value;
				}
			}
			return $object;
		}

        public function flattenArray($arr, $keyname, $valname) {
            $out = array();
            foreach($arr as $r) {
                $out[$r[$keyname]] = $r[$valname];
            }
            return $out;
        }
        
        public function findKeyInArray($arr, $findWhat) {
            foreach($arr as $key => $val) {
                if (strtolower($val) == strtolower($findWhat))
                    return $key;
            }
            return false;
        }
        
        protected function hasAttribute($attribute) {
            return property_exists($this, $attribute);
        }
		

		
		protected function attributes() {
            global $db;
            
			$attributes = array();
			$fields = $db->showFields($this->table);
			
			foreach($fields as $field) {
				if(property_exists($this, $field)) {
					$attributes[$field] = $this->$field;	
				}
			}
			return $attributes;
		}           
		
		protected function cleanAttributes () {
            global $db;
           
			$clean_attributes = array();
			foreach($this->attributes() as $key => $value) {
				$clean_attributes[$key] = $db->escapeString($value);
			}
			return $clean_attributes;
		}
		
		public function prepare($result_array) {
			return !empty($result_array) ? array_shift($result_array) : false;	
		}
		

/* ================================================	
	Reading and Writing to Forms
   ================================================	 */
		
        public function fillFromForm($form) {
            global $db;
			
			foreach($form as $k => $v) {
               if (is_array($v)) {
					$escArr = array();
					
					foreach($v as $value) {
						$value = $db->escapeString($value);
						$escArr[] = $value;
					}
					if ($this->hasAttribute($k)) $this->$k = $escArr;
			   } else { 
				$v = $db->escapeString($v);
			   	if ($this->hasAttribute($k)) $this->$k = $v;
			   }
            }
		}

        public function pushToForm() {
            global $db;
           
		    $html = "<script> ";
            foreach($this->attributes() as $k => $v) {
               $html .= "$('#".$k."').val('".$db->escapeString($v)."'); ";
            }
            $html .= "</script>";

            return $html;
        }


/* ================================================	
	CRUD Methods
   ================================================	 */

		public function save($id="") {
			//echo "ID in SAVE Method: " . $id;
			return !empty($id) ? $this->update($id) : $this->create();
		}
		
		public function create() {
            
			global $db;
            //echo "creating ". $this->table . "<br />";
			
			$attributes = $this->cleanAttributes();
			$attribute_pairs = array();
            
			foreach($attributes as $key => $value) {
                if ($key != $this->indirectId())
                    $attribute_pairs[$key] = $this->quoteField($value);     
            }	
			
			//INSERT INTO table (key, key) VALUES ('value', 'value')
			$sql = "INSERT INTO " . $this->table . "(";
			$sql .= join(", ", array_keys($attribute_pairs));	
			$sql .= ") VALUES (";
			$sql .= join(", ", array_values($attribute_pairs));
			$sql .=")";
			
			
			if ($db->query($sql)) {
				return $db->insertedID();
			} 
            
			return false;
		}
		
        public function quoteField($fld) {
            if (is_numeric($fld)) {
                return $fld;
            } else {
                return "'".$fld."'";
            }
        }
        
		public function update($idval="") {
            global $db;
           //echo "updating<br />";
		   
			$attributes = $this->attributes();
			$attribute_pairs = array();
			foreach($attributes as $key => $value) {
                if ($key != $this->idfield)
				    $attribute_pairs[] = "{$key} = ". $this->quoteField($value); 	
			}
			
			//UPDATE table SET key='value', key='value' WHERE condition
			$sql = "UPDATE " .$this->table. " SET ";
			$sql .= join(", ", $attribute_pairs);
			$sql .= " WHERE " .$this->idfield. "=". $this->quoteField($idval);
			
			//echo $sql;
			
			$result = $db->query($sql);
			
			return $idval;
		}
		
		public function delete($idval = "") {
            global $db;
			if (empty($idVal)) $idVal = $this->indirectId();
            
			//DELETE FROM table  WHERE condition LIMIT 1
			$sql = "DELETE FROM " .$this->table;
			$sql .= " WHERE " . $this->idfield ."=" .$this->quoteField($idval);
           
            $db->query($sql);
            return($db->affectedRows() > 0) ? true : false;
		}
		
		
		//Date Methods
		public function displayDate($date) {
			return date('m/d/Y', strtoTime($date));	
		}
		
		public function setDatesForDatabase($date) {
			$dateArr = explode("/", $date);
			
			$dateTime = new DateTime();
			$dateTime = $dateTime->setDate($dateArr[2], $dateArr[0], $dateArr[1]);
			$date = $dateTime->format("Y-m-d h:i:s");
			
			return $date;
		}
		
		
		//Indirection of the ID
		public function indirectId () {
			return $this->{$this->idfield};	
		}
		
		
		
/* ================================================	
	Blog and Publish Methods
   ================================================	 */
		
		//Publish and Unpublish methods
		public function published($id="") {
			if (empty($id)) $id = $this->$idfield;
			
			$html = '<a  sel="'.$this->table. '" id="'.$id.'"';
			if ($this->published == 1) $html .= 'published="yes"';
			
			if ($this->published == 1) {
				$html .= ' class="published ninjaSymbol ninjaSymbolCheck" ></a>';
			} else {
				$html .= ' class="published ninjaSymbol ninjaSymbolNot" ></a>';
			}
			
			return $html;
		}
		
		
		public function publish() {
			global $db;
			$db->query("UPDATE {$this->table} SET published = 1 WHERE {$this->idfield} = {$this->indirectId()}");
			return ($db->affectedRows() > 0);
		}
		
		public function unpublish() {
			global $db;
			$db->query("UPDATE {$this->table} SET published = 0 WHERE {$this->idfield} = {$this->indirectId()}");
			return ($db->affectedRows() > 0);
		}
		
		//Set new Position 
		public function setPosition ($newPosition, $varName) {
			global $db; 
			
			$position = $varName;
			
			$posLow = $position;
			$posHigh = $newPosition;
			
			if ($posLow > $posHigh) {
				$posLow = $newPosition;
				$posHigh = $position;
			}
			
			
			$db->query("UPDATE {$this->table} SET position = 4000 WHERE position = {$position}");
			$db->query("SELECT @sign:= SIGN({$position}-{$newPosition}) FROM {$this->table}");
			$db->query("UPDATE {$this->table} SET position = @sign + position WHERE position BETWEEN {$posLow} AND {$posHigh}");
			$db->query("UPDATE {$this->table} SET position = {$newPosition} WHERE position = 4000");
			
			if ($db->affectedRows() > 0) {
			
			}
		}	
		
		//Create the arrows for position
		public function moveArrows ($id, $varName, $link) {
			$position = $varName;
			
			$html = '<ul class="moveArrows">
						<li class="'.$this->table.'" sel="'.$position.'">';
			if ($position != $this->topPosition($position)) {
				$html .='<a sel="'.$id.'" class="move ninjaSymbol ninjaSymbolMoveUp" title="moveUp" href="'.$link.'"></a>'; 
			}
			
			$html .=	'</li>
						<li class="'.$this->table.'" sel="'.$position.'">';
			
			if ($position != $this->bottomPosition($position)) {
				$html .= '<a sel="'.$id.'" class="move ninjaSymbol ninjaSymbolMoveDown" title="moveDown" href="'.$link.'"></a>';
			}
			
			
			$html .= '</li></ul>';
			return $html;	
		}
		
		//Find out if item is in top position
		public function topPosition() {
			global $db;
			
			$result = $db->queryFill("SELECT * FROM {$this->table}  ORDER BY position ASC LIMIT 1");
			$result = array_shift($result);
			
			return $result['position'];
		}
		
		//Find out if item is in bottom position
		public function bottomPosition() {
			global $db;
			
			$result = $db->queryFill("SELECT max(position) AS 'position' FROM {$this->table}");
			$result = array_shift($result);
			return $result['position'];
		}
		
		
		//Get Access GroupName from Id
		public function accessGroupName($id) {
			global $db;
			
			$result_set = $db->queryFill("SELECT groupname FROM userGroups WHERE group_id = $id LIMIT 1");
			if ($result_set != false) {
				$result_set = array_shift($result_set);
				return 	$result_set['groupname'];	
			}
			
			return false;
		}
			
		//List all Access Groups
		public function listAccessGroups() {
			global $db;
			$list = array();
			
			$result_set = $db->queryFill("SELECT * FROM userGroups");
			
			if ($result_set != false) {
				$result_set = $this->arrayShift($result_set);
				
				foreach ($result_set as $name) {
					$list[] = $name;
				
				}
			}
			return $list;
		}
		
		public function accessDropDown($id, $navid="") {
			$array = $this->listAccessGroups();
			
		
			$html = '<select id="access" class="'.$this->table.'" name="access"';
			
			if (isset($navid)) 
				$html .= ' sel="'. $navid.'">';
		
			foreach($array as $list){
				$html .= '<option value="'. $list['group_id'].'" '; 
				if ($id == $list['group_id']) {
					$html .= 'selected="selected" ';
				} 
				
				$html .= ' >'. $list['groupname'].'</option>';
			}
			
			$html .= "</select>";
			
			return $html;
		}
		
		public function setAccess($newAccess, $id) {
			global $db;
				
			$result_set = $db->query("UPDATE {$this->table} SET access = {$newAccess} WHERE {$this->idfield} = {$id}");
			if ($db->affectedRows() > 0) return true;
		}

		
		

}	



?>
