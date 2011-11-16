<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); 
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');
	
	if (isset($_GET['h'])) { 
		$search = $_GET['h']; 
	} else { 
		$nosearch = 1;
	}
	
?>

<section class="mainContent">
	<article>
    	<?php if (isset($nosearch)) {
			
		} else {
			echo $display->siteSearch($search, 1);	
		}
		
		?>
    </article>
    
    <aside>
    	<?php //include(MODULES.'sidebar.php'); ?>
    </aside>
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>        
       