<?php
    require_once('../includes/admin_require.php');
	$nav = new AdminNavigation();

	$sel = $_POST['sel'];
    $href = $_POST['href'];
	
	$tabs = $nav->displayTabNavigation($sel);
	
	echo json_encode (array (
		"tabs" => $tabs,
		"href" => $href
	));	
    



 ?>
