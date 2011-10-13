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
		$classname = $_POST['table'];
		$class = new $classname($_POST['primary_key']);
		$class->deleteFromForm();
		echo true;
	} else if(isset($_POST['select'])) {
		// select for column txn_id
		if($_POST['col'] == "txn_id") {
			$grid->where = "txn_id IS NOT NULL";
			$grid->limit = 5;
			$grid->makeSelect("txn_id","txn_id");
			echo json_encode($grid->data);
		}	
	} else {
		if ($_POST['table'] == 'content') {
		
		} else  if ($_POST['table'] == 'users') {
			$users = new Users();
			
			$grid->joins = array(
      			"JOIN userInGroups ON (users.user_id = userInGroups.user_id)"
 			);
			$grid->fields = array(
			  'access'=> 'userInGroups.group_id',
			  'name'=>"CONCAT(users.first,' ', users.last )",
			);
			
		}
		
		$grid->load();
	
		//Change any data before placing in JSON
		if (isset($_POST['load'])) {
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
			case 'users':
				users($grid->data);
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
			$row['modified_on'] = $users->displayDate($row['modified_on']);
			$row['access'] = $content->accessDropDown($row['access'], $row['content_id']);
		}
		
		
	}
	
	function users(&$dataArray) {
		global $grid;
		
		foreach ($dataArray['rows'] as &$row) {
			$users = new Users($row['user_id']);
			
			$row['email'] = $users->email;
			$row['NPINumber'] = $users->NPINumber;
			$row['company'] = $users->company;
			$row['access'] = $users->accessDropDown($row['access'], $row['user_id']);
		}
	}

	
	
?>


