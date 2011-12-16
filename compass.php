<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); 
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');
?>
<section class="mainContent">
	<div class="row">
    	<?php if ($display->drugList != false) : ?>
        <aside class="fourcol">
            <?php $display->drugNavigation(); ?>
        </aside>
        <?php endif; ?>
        <article class="eightcol last">
           	<h1><?php $display->displayTitle(); ?></h1>
            <?php $display->displayContent(); ?>
        </article>
    </div>
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>        
       