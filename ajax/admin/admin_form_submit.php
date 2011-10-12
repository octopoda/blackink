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
	
	$created = $navigation->createNavigationFromForm($_POST);
	
	if ($created) {
		echo $_POST['addNavigation'];	
	} else {
		return false;	
	}
}

if (isset($_POST['addContent'])) {
	if (isset($_POST['content_id'])) $id = $_POST['content_id'];
	$content = new Content($id);
	
	$created = $content->createContentFromForm($_POST);
	
	if ($created) {
		echo $_POST['addContent'];	
	} else {
		echo $_POST['addContent'];
	}	
}

?>


