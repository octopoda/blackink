<?php
require_once("databaseObject.php");


    //Class and Table need to be the same name
    class UserGroups extends databaseObject{

        public $table = "userGroups";
        public $idfield = "group_id";
        public $group_id;
        public $groupname;
        public $position;

		public function __construct($id="") {
			if (empty($id)) $id = $this->group_id;

			$this->fetchById($id);


		}

/* 	================================================
   	Build Setup Methods
	==============================================*/


/* 	================================================
   	Display Methods
	==============================================*/


/* 	================================================
   	Admin Methods
	==============================================*/
		public function positionDropDown($menu_id="", $parent_id="") {
			global $db;
			global $error;


			if ($menu_id === false) $menu_id = $this->menu_id;
			if ($parent_id === false) $parent_id = $this->parent_id;


			$html = '<label for="position">Postion (Place Below Selection)</label>';
			$html .=  '<select name="position" id="position" class="changePosition">';

			$sql = "SELECT position, groupname FROM {$this->table} ORDER BY position";
			$result_set = $db->queryFill($sql);

			if ($result_set != false) {
				$html .= '<option value="0">Top</option>';
				foreach ($result_set as $row) {
					$html .= '<option value="'. $row['position'].'">'.$row['groupname'].' ('.$row['position'].')</option>';
				}
			} else {
				$html .= '<option value="0">Top</option>';
			}

			$html .= "</select>";
			return $html;
		}


/* 	================================================
   	CRUD
	==============================================*/


        public function createFromForm($post) {
        	global $error;
			global $db;

        	$this->fillFromForm($post);

        	//Edit UserGroups Position Set
			if ($this->group_id != false) {
				$positionNav = new UserGroups($this->group_id);
				$oldPosition = $positionNav->position;
				$this->group_id = $this->save($this->group_id);
				$this->setPosition($this->position, $oldPosition);

			//New UserGroups Position Set
			} else {
				$this->position = $this->position; // 3
				$position_set = $db->queryFill("SELECT position FROM userGroups WHERE position = {$this->position} LIMIT 1");
				if ($position_set != false) {
					$position_set = $this->arrayShift($position_set);
					$setPosition = $position_set['position']; //3
					$newPosition = $setPosition+1; //4
					$this->setPosition($newPosition, $setPosition);
					$this->group_id = $this->save($this->group_id);
				} else {
					$this->group_id = $this->save($this->group_id);
				}
			}

			if (!empty($this->group_id)) {
				return $this->group_id;
			} else {
				$error->addError('The userGroup did not save', 'UG1873');
			}
		}



        public function deleteFromForm() {
        	global $error;
        	global $db;

        	//Reset Importance
        	$run = $db->query("UPDATE {$this->table} SET position = position-1  WHERE position > {$this->position} AND NOT position = 200");

			if ($this->delete($this->group_id)) {
				return true;
			} else {
				$error->addError('The information did not save.', 'UGroups1564');
			}
        }


	}



?>