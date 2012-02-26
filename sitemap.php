<?php  
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');
	$site = new Site();
	
	
	$xml =  '<code><?xml version="1.0" encoding="UTF-8"?>
		  	 <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

	
	$navList = Navigation::ListAllNav();

	foreach ($navList as $nav) {
		$nav = new Navigation($nav['navigation_id']);
		$content = new Content($nav->content_id);
		
		if ($nav->access >= 2) {
			continue;		
		}
		 
		if ($nav->xmlLink() != NULL) {
			$xml .= '<url>';
			
			if ($nav->xmlLink() != 'index.html') {
				$xml .='<loc>http://'.$site->siteURL.'/'.$nav->xmlLink().'</loc>';	
			} else if ($nav->link != NULL) {
				$xml .='<loc>http://'.$site->siteURL.'/'.$nav->link.'</loc>';	
			}else {
				$xml .='<loc>http://'.$site->siteURL.'/'.'</loc>';	
			}
			$xml .='<lastmod>'.date("Y-m-d", strtotime($content->modified_on)).'</lastmod>';
			$xml .= '<changefreq>weekly</changefreq>';
		
			if ($nav->default_page == 1) {
				$xml .= "<priority>1.0</priority>";	
			} else if ($nav->parent_id == 0) {
				$xml .= "<priority>0.9</priority>";		
			} else {
				$xml .= "<priority>0.8</priority>";		
			}	
			
			$xml .= '</url>';
		} 
	}
	
	$xml .= "</urlset></code>";
	echo $xml;

 ?>
 

    
