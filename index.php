<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); 
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');
	echo $_GET['title'];
?>

<section class="mainContent">
	<article>
    	<?php $display->displayContent(); ?>
    </article>
    
    
    <aside>
    	<?php include(MODULES.'sidebar.php'); ?>
    </aside>
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>        
       