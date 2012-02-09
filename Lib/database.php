<?php
   require_once("web_config.php");	
	
	class MySQLDatabase {
		private $database;
		public $lastQuery;
		private $magic_quotes_active;
		private $real_escape_string_exists;
		
		public function __construct () {
            if (session_id() == NULL) session_start();
            if (!function_exists('mysql_connect')) {
                 die('Please make sure the MySQL extension is loaded in php.ini.');
            }
			
			$this->openConnection();
			$this->magic_quotes_active = get_magic_quotes_gpc();
			$this->real_escape_string_exists = function_exists("mysql_real_escape_string" ); 
            $this->query('set names utf8');
            $this->query('set character set utf8');
            $this->query('set character_set_connection=utf8');            
		}
		
		private function openConnection ()  {
			$this->database = new mysqli (HOSTNAME, DB_USER, DB_PASS, DB_NAME);
			
			/* check connection */
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
		}
		
			
		public function close () {
			 if (isset($this->connection)) {
				$mysqli->close($this->connection); 
				unset($this->connection);
			  }
		}
		
		public function query($sql) {
			//echo $sql . '<br />';
			$this->lastQuery = $sql;
			$this->escapeString($sql);
			$result = $this->database->query($sql);
			$this->confirmQuery($result);
			
			return $result;
		}
		
		public function startTransaction() {
			$this->database->query("START TRANSACTION");	
		}
		
		public function endTransaction() {
			$this->database->query("END TRANSACTION");	
		}
		
		public function rollbackTransaction() {
			$this->database->query("ROLLBACK TRANSACTION");	
		}
		
        public function queryFill($sql) {
           	$rtn = $this->query($sql);
            if (empty($rtn)) return false;
            $row_array = array();
            
			
			while ($row = $rtn->fetch_assoc()) {
               $row_array[] = $row;
			}
			
			return $row_array;
        }
        
        
		private function confirmQuery ($result) {
			if (!$result) {
				$output = "<p>Database Query Failed:" . $this->database->error . "</p>";
				$output .= "<p>Last SQL Query: " . $this->lastQuery . "</p>";
				die($output);	
			}	
		}
		
		public function escapeString ($value) {
			if ($this->real_escape_string_exists) { 
				if ($this->magic_quotes_active) {$value = stripslashes($value); }
				$value = $this->database->real_escape_string($value);
			} else {
				if (!$this->magic_quotes_active) {$value = addslashes($value); }
			}
			return $value;	
		}

		//Database-neutral methods
		public function fetchArray($result_set) {
			return $result_set->fetch_array();
		}
		
		public function fetchAssoc($result_set) {
			return $result_set->fetch_assoc();	
		}
		
		public function numRows($result_set) {
			return $result_set->num_rows;	
		}
		
		public function fieldCount($result_set) {
			return $result_set->field_count;	
		}
		
		public function insertedID() {
			return $this->database->insert_id;	
		}
		
		public function affectedRows() {
			return $this->database->affected_rows;	
		}
		
		public function showFields($table) {
			$res = $this->query("SHOW COLUMNS FROM {$table}");
			$fieldNames = array();
			
			while ($row = $res->fetch_array()) {
				$fieldNames[] = $row['Field'];
			}
			
			return $fieldNames;
		}
		
        public function getNext($qry) {
            return @mysqli_fetch_array($qry, MYSQL_ASSOC);
        }        

        public function freeQuery($qry) {
            if ($qry) mysqli_free_result($qry);
        }            
        
        public function getOneRow($sql) {
            $qry = $this->query($sql);
            $rslt = $qry ? $this->getNext($qry) : NULL;
            $this->freeQuery($qry);
            return $rslt;
        }
        
        public function getAllRows($sql) {
            $qry = $this->query($sql);
            if ($qry) {
                $rslt = array();
                while ($v = $this->getNext($qry)) {
                    array_push($rslt, $v);
                }
                $this->freeQuery($qry);
            } else 
                $rslt = FALSE;
            return $rslt;
        }
		
		
	}
	
	$database = new MySQLDatabase();
	$db =& $database;
?>
