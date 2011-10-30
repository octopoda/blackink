<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); 
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');
?>

<header>
	<hgroup>
    	<h1><a href="/index.php"><?php echo $site->siteName; ?></a></h1>
    </hgroup>
	<nav>
    	<?php $display->displayMenu('Quick Menu'); ?>
    </nav>
    
    
</header>
<section>
	<nav>
    	<?php $display->displayMenu('Main Menu'); ?>
    </nav>
</section>
<div class="mainContent">
	<section>
    	<?php $display->displayContent(); ?>
    </section>
    
    <aside>
    </aside>
</div>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>        
       