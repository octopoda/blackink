<?php 
	require_once('includes/require.php');
	
	//$array = array('navigation_id'=>'navigation');
	//$array = array('content_id'=>'content', 'ad_id'=>'ads', 'news_id'=>'news');
	
	foreach ($array as $k=>$a) {
		$title = $db->queryFill("SELECT title, {$k} FROM {$a}");
		foreach ($title as $t) {
			
			$class = new $a();
			$tits = $class->sanitize($t['title'], true);
			$id = $t[$k];
			$db->query("UPDATE $a SET directLink = '{$tits}' WHERE {$k} = {$id}");		
		}
	}
	
	 echo 'done';
?>