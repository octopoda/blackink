<?php

class Pagination
{
	
	public $page;
	public $size;
	public $total_records;
	public $searchTerm;
	public $classname;
	
	
	public function __construct($classname="")
	{
		$this->classname = $classname;
	}
	
	public function setupPagination($page, $size, $totalRecords) {
		$this->page = $page;
		$this->size = $size;
		$this->total_records = $totalRecords;
		
	}
	
	public function setSearch($searchTerm) {
		$this->searchTerm = $searchTerm;	
	}
	
	
		
	public function setTotalRecords($total)
	{
		$this->total_records = 0+$total;
	}
	
	
	public function getLimitSql()
	{
		$sql = "LIMIT " . $this->getLimit();
		return $sql;
	}
		
	private function getLimit()
	{
		if ($this->total_records == 0) {
			$lastpage = 0;
		} else {
			$lastpage = ceil($this->total_records/$this->size);
		}
		
		$page = $this->page;		
		
		if ($this->page < 1) {
			$page = 1;
		} else if ($this->page > $lastpage && $lastpage > 0){
			$page = $lastpage;
		} else {
			$page = $this->page;
		}
		
		$sql = ($page - 1) * $this->size . "," . $this->size;
		
		return $sql;
	}
	
	public function create_links()
	{
		$totalItems = $this->total_records;
		$perPage = $this->size;
		$currentPage = $this->page;
		
		$totalPages = floor($totalItems / $perPage);
		$totalPages += ($totalItems % $perPage != 0) ? 1 : 0;
		
		if ($totalPages < 1 || $totalPages == 1){
			return null;
		}
		
		if ($currentPage > $totalPages) 
			$currentPage = $totalPages;	
		else if ($currentPage < 1) 
			$currentPage = 1;	
		

		$output = null;
				
		$loopStart = 1; 
		$loopEnd = $totalPages;
		
		if ($totalPages > 5) {
			if ($currentPage <= 3){
				$loopStart = 1;
				$loopEnd = 5;
			}else if ($currentPage >= $totalPages - 2) {
				$loopStart = $totalPages - 4;
				$loopEnd = $totalPages;
			} else {
				$loopStart = $currentPage - 2;
				$loopEnd = $currentPage + 2;
			}
		}
		
		return $this->buildHTML($currentPage, $totalPages);
	}
	
	private function buildHTML($currentPage, $totalPages) {
		$html = "";
		
		if ($currentPage > 1) {
			$html .= '<li class="prevpage" data-page="'.($currentPage-1).'"><a class="ninjaSymbol ninjaSymbolArrowLeft"></a></li>';	
		} 
		
		$html .= '<li id="total_page">Page <input type="text" maxlength="3" value="'.$currentPage.'" /> of '.$totalPages.'</li>';
		
		
		if ($currentPage < $totalPages) {
			$html.= '<li class="nextpage"  data-page="'.($currentPage+1).'" ><a class="ninjaSymbol ninjaSymbolArrowRight"></a></li>';
		}
		
		return '<ul class="pagination" data-term="'.$this->searchTerm.'" data-class="'.$this->classname.'">' . $html . '</ul>';
	}
}

?>