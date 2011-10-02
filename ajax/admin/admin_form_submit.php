<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/require.php'); 

//echo 'hello';
//print_r($_POST);

if (isset($_POST['siteForm'])) {
	$site = new Site();
	
	if ($site->createFromForm($_POST)) {
		echo 'forms/site.php';
	} else {
		return false;	
	}
}


if (isset($_POST['addMenu'])) {
	$menu = new Menus();
	
	if ($menu->createMenuFromForm($_POST)) {
		echo $_POST['addMenu'];	
	} else {
		echo $_POST['addMenu'];
	}
}

if (isset($_POST['addNavigation'])) {
	if (isset($_POST['navigation_id'])) $id = $_POST['navigation_id'];
	$navigation = new Navigation($id);
	
	$navigation->createNavigationFromForm($_POST);
	/*
	if ($navigation->createNavigationFromForm($_POST)) {
		echo $_POST['addNavigation'];	
	} else {
		echo $_POST['addNavigation'];
	} */
}

?>


