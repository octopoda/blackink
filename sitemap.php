<?php  
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');
	$sections = array();
	$sitemap = new Sitemap($sections);
	
	echo $sitemap->xml;

 ?>
 

    
