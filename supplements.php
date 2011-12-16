<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); 
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');
?>
<section class="mainContent">
	<div class="row">
    	<aside class="threecol">
            <?php $display->supplementNavigation(); ?>
        </aside>
        <article id="supplements" class="eightcol last">
        	<h1>Orthomolecular Supplements</h1>
           <?php $display->displaySupplements(); ?>
        </article>
    </div>
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>        
       