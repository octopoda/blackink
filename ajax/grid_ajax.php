<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/require.php'); 

	
	// load our grid with a table
	$grid = new Grid($_POST['table']);
	
	
	//for editing check for the save flag and call save
	if(isset($_POST['save'])) {
		$grid->security = array("n_items");
		echo $grid->save();
	} else if(isset($_POST['add'])) {
		$grid->add();
	} else if(isset($_POST['delete'])) {
		$grid->delete();
	} else if(isset($_POST['select'])) {
		// select for column txn_id
		if($_POST['col'] == "txn_id") {
			$grid->where = "txn_id IS NOT NULL";
			$grid->limit = 5;
			$grid->makeSelect("txn_id","txn_id");
			echo json_encode($grid->data);
		}	
	} else {
		$grid->load();
		
		//Change any data before placing in JSON
		if (isset($_POST['table'])) {
			runFunctions($_POST['table']);	
		}
		
		//print_r($grid->data);
		echo json_encode($grid->data);
	}
	
	//Add each grid that you need to change data for here.  The $name is on the HTML tag Table attribute sel 
	function runFunctions($name) {
		global $grid;
		
		switch ($name) {
			case 'content':
				content($grid->data);
				break;
		}
		
		
	}
	
	//Functions for Content Grid
	function content(&$dataArray) {
		global $grid;
		
		foreach ($dataArray['rows'] as &$row) {
			$users = new Users($row['user_id']);
			$content = new Content($row['content_id']);
			
			$row['user_id'] = $users->printName();
			$row['published'] = $content->published($row['content_id']);
			$row['created_on'] = $users->displayDate($row['created_on']);
			$row['modified_on'] = $users->displayDate($row['modified_on']);
			$row['access'] = $users->accessGroupName($row['access']);
		}
	}
	
	
?>


