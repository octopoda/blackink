<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); 
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');
?>

<section class="homeContent">
	<div class="row mobileRefill">
		<div class="sixcol">
		<?php include(MODULES. 'refills.php');  ?>
        </div>
	</div>
    
    <div class="row">
        <article class="twelvecol">
           	<h1><?php $display->displayTitle(); ?></h1>
            <?php $display->displayContent(); ?>
        </article>
      </div>
       <div class="contentShadow"></div>
      <section class="homeLower">
      	<article class="row">
            <div class="sevencol homeAds">  
                <?php echo $display->displayAds('Front Page') ?>
            </div>
            <div class="fourcol homeNews">
            	 <?php include(MODULES. 'refills.php');  ?>
				 <?php echo $display->displayNews(); ?>
            </div>
        </article>
      </section>
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>        
       