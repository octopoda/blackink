<?php

require_once('../includes/require.php');


if (isset($_POST['title'])) {
	$uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/images/projects/'; 
	$file = $uploaddir . basename($_FILES['uploadfile']['name']); 
	$name = basename($_FILES['uploadfile']['name']);
	
	//Setup to enter information in DB
	$image = new ProjectImages();
	
	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
		$image->image_id = $image->fillUploadImage($_POST, $name);
		$image->connectImageToProject($image->image_id, $_POST['id']);
		
		//Get new image List
		$project = new Project($_POST['id']);
		echo ProjectView::previewImages($project->imageList, $_POST['href']); 
	} else {
	  echo "error";
	}
}


if (isset($_POST['thumbnail_id'])) {
	$uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/images/thumbnails/'; 
	$file = $uploaddir . basename($_FILES['uploadfile']['name']); 
	$name = basename($_FILES['uploadfile']['name']);
	
	//Setup to enter information in DB
	$project = new project($_POST['project_id']);
	$thumbnail = new Thumbnails();
	
	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
		$thumbnail->alt_name= $project->projectTitle;
		$thumbnail->file_name = $name;
		$thumbnail->thumbnail_id = $thumbnail->save($thumbnail->indirectId());
		$thumbnail->changeThumbnail($project->project_id);
		echo  $_POST['href']; 
	} else {
	  echo "error";
	}	
}
?>