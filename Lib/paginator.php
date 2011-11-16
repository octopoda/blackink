<?php

class Paginator
{
	
	public $page;
	public $size;
	public $total_records;
	public $searchTerm;
	
	public function __construct($page = null, $size = null, $totalRecords = null,  $searchTerm = null)
	{
		$this->page = $page;
		$this->size = $size;
		$this->total_records = $totalRecords;
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
		if ($this->total_records == 0)
		{
			$lastpage = 0;
		}
		else 
		{
			$lastpage = ceil($this->total_records/$this->size);
		}
		
		$page = $this->page;		
		
		if ($this->page < 1)
		{
			$page = 1;
		} 
		else if ($this->page > $lastpage && $lastpage > 0)
		{
			$page = $lastpage;
		}
		else 
		{
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

		if ($totalPages > 5)
		{
			if ($currentPage <= 3)
			{
				$loopStart = 1;
				$loopEnd = 5;
			}
			else if ($currentPage >= $totalPages - 2)
			{
				$loopStart = $totalPages - 4;
				$loopEnd = $totalPages;
			}
			else
			{
				$loopStart = $currentPage - 2;
				$loopEnd = $currentPage + 2;
			}
		}

		if ($currentPage > 1){
			$output .= sprintf('<li class="prevpage" sel="'.($currentPage-1).'"><a class="ninjaSymbol ninjaSymbolArrowLeft"></a></li>', $currentPage - 1);
		}
		
		$output .= '<li id="total_page">Page <input type="text" maxlength="3" value="'.$currentPage.'" /> of '.$totalPages.'</li>';
		
		if ($currentPage < $totalPages){
			$output .= sprintf('<li class="nextpage"  sel="'.($currentPage+1).'" ><a class="ninjaSymbol ninjaSymbolArrowRight"></a></li>', $currentPage + 1);
		}
		
		
		return '<ul class="pagination" sel="'.$this->searchTerm.'">' . $output . '</ul></div>';
	}
}

?>