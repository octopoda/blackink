<?php

require_once('../includes/require.php');


if (isset($_POST['media'])) {
	//Setup to enter information in DB
	$media = new Media();
	
	
	$uploaddir = $_SERVER['DOCUMENT_ROOT'] . $media->directory; 
	$file = $uploaddir . basename($_FILES['file_name']['name']); 
	$name = basename($_FILES['file_name']['name']);
	$_POST['file_name'] = $name;
	
	
	//Check for Duplicates and return duplicate
	$dup_id = $media->duplicate($name);
	if ($dup_id != false) {
		$error->addMessage("This file has already been uploaded.");
		echo $_POST['link'];	
		return;
	}
	
	if (move_uploaded_file($_FILES['file_name']['tmp_name'], $file)) { 
		$media->createMedia($_POST);
		$error->addMessage("The file was uploaded");
		echo $_POST['link'];
		return;
	} else {
	  $error->addError('The file did not upload.', 'Ajax_upload1985');
	} 
}


if (isset($_POST['content'])) {
	$media = new Media();
	
	$uploaddir = $_SERVER['DOCUMENT_ROOT'] . $media->directory; 
	$file = $uploaddir . basename($_FILES['file_name']['name']); 
	$name = basename($_FILES['file_name']['name']);
	$_POST['file_name'] = $name;
	
	
	//Make sure file name is set up correctly
	if (!$media->checkFileName($name)) {
		return;	
	}
	//Check for Duplicates and return the file link
	$dup_id = $media->duplicate($name);
	if ($dup_id != false) {
		$dup = new Media($dup_id);
		echo $dup->file_link;
		return;	
	}
	
	if (move_uploaded_file($_FILES['file_name']['tmp_name'], $file)) { 
		$saveMedia_id = $media->createMedia($_POST);
		
		$saveMedia = new Media($saveMedia_id);
		echo $saveMedia->file_link;
	} else {
	  	$error->addError('The file did not upload.', 'Ajax_upload3625');
	} 	
}


?>