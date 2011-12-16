<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); 
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');
?>
<section class="mainContent">
	<div class="row">
       <article class="eightcol">
           	<h1><?php $display->displayTitle(); ?></h1>
            <?php $display->displayContent(); ?>
        </article>
        
        
        <aside class="fourcol last">
            <?php include(MODULES.'sidebar.php'); ?>
        </aside>
    </div>
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>        
       