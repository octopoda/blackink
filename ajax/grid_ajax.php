<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/require.php'); 


	
	// load our grid with a table
	$grid = new Grid($_POST['table']);
	
	
	//for editing check for the save flag and call save
	if(isset($_POST['save'])) {
		//$grid->security = array("n_items");
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
		$dataArray = array();
		$grid->load();
		
		//Change any data before placing in JSON
		if (isset($_POST['functions'])) {
			$dataArray = runFunctions($_POST['functions']);	
		}
		
		//print_r($grid->data);
		echo json_encode($grid->data);
	}
	
	
	function runFunctions($name) {
		global $grid;
		
		switch ($name) {
			case 'content':
				content($grid->data);
				break;
		}
		
		
	}
	
	function content(&$dataArray) {
		global $grid;
		
		$count = count($grid->data['rows']);
		//print_r($grid->data);
		/* for ($i = 1; $i < $count; $i++) {
			$users = new Users($grid->data['rows']['_'.$i]['user_id']);
			$grid->data['rows']['_'.$i]['user_id'] = $users->printName();
		}*/
		
		foreach ($dataArray['rows'] as &$row) {
			$users = new Users($row['user_id']);
			$row['user_id'] = $users->printName();
			
			$row['created_on'] = $users->displayDate($row['created_on']);
			$row['modified_on'] = $users->displayDate($row['modified_on']);
			$row['access'] = $users->accessGroupName($row['access']);
		}
		
		
	}
?>


