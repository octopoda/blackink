<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); 
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');
	
	$site = new Site();
	$menus = new Menus();
	$menus->listMenus();
	$html = "";
	
	
	
	
	
?>

<section class="mainContent">
	<div class="row">
        <article class="eightcol">
            <h1>Site Map</h1>
			<?php 
				foreach ($menus->menuList as $menu) {
					if ($menu->access >= 2) {
						continue;	
					}
					
					echo '<h1>'.$menu->menu_name.'</h1>';
					
					$display->displayMenu($menu->menu_name);
					
				}
            ?>
        </article>
    
    	<aside class="fourcol last">
    		<?php include(MODULES.'sidebar.php'); ?>
    	</aside>
    </div>
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>        
       