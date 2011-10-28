<?php

require_once('../includes/require.php');


if (isset($_POST['media'])) {
	$media = new Media();
	
	
	$uploaddir = $_SERVER['DOCUMENT_ROOT'] . $media->directory; 
	$file = $uploaddir . basename($_FILES['file_name']['name']); 
	$name = basename($_FILES['file_name']['name']);
	$_POST['file_name'] = $name;
	
	//Setup to enter information in DB
	$media = new Media();
	
	//Make sure file name is set up correctly
	if (!$media->checkFileName($name)) {
		return;	
	}
	
	if (move_uploaded_file($_FILES['file_name']['tmp_name'], $file)) { 
		$media->createMedia($_POST);
		$error->addMessage("The file was uploaded");
		echo $_POST['link'];
	} else {
	  $error->addError('The file did not upload.', 'Ajax_upload1985');
	} 
}



?>