<?php
require_once(CLASS_PATH.DS. 'database.php');

class Paginator{

	private $numRows;
	private $totalPages;
	private $pageObject;
	private $result_set;
	private $sqlString;
	private $offset;
	private $table;
	private $headerArray;
	
	//Editable Vars 
	public $rowsPerPage = 10;
	public $currentPage = 1;
	public $range = 3;
	
	//Buttons
	
	function __construct($table) {
		$this->table = $table;
		
		
		$this->pageObject = new $table();
		$this->getNumbers();
		$this->getCurrentPage();
		$this->runSQL();
	}
	
	//Get num rows and total Pages
	private function getNumbers() {
		global $db;
		$this->result_set = $db->query("SELECT COUNT(*) FROM {$this->table}");
		$this->numRows = $db->numRows($this->result_set);
		$this->totalPages = ceil($this->numRows / $this->rowsPerPage);		
	}
	
	//Get current Page and Set Offset 
	private function getCurrentPage($currentPage="") {
			if (!isset($currentPage)) $currentPage = $this->currentPage;
			
			if ($this->currentPage < 1) {
				$this->currentPage = 1;	
			} else if ($this->currentPage > $this->totalPages) {
				$this->currentPage = $this->totalPages;	
			}
			
			$this->offset = ($this->currentPage - 1) * $this->rowsPerPage;
	}
	
	//Run SQL to get Information
	private function runSQL() {
		global $db;
		
		$this->sqlString = $this->pageObject->pagination($this->offset, $this->rowsPerPage);
		$this->result_set = $db->queryFill($this->sqlString);
	}
	
	//Build back and Forward Buttons
	public function buildTable() {
		foreach ($this->result_set as $key=>$value) {
		}
		
	}
	
}