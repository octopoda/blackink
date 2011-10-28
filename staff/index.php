<?php 
    require('includes/header.php');
	$error->clearErrors();
	$nav = new AdminNavigation();
	
	if (!isset($_SESSION['user_id'])) redirect('login.php');
	$site = new Site();
?>

<section id="siteWrapper">
    <header class="clearfix row">
       <hgroup>
           <h1><?php echo $site->siteName; ?></h1>
           <h2>Black Ink Content Management System</h2>
       </hgroup>
       
       <!-- Quick Navigation and search  -->
       <ul>
       	
       </ul>
    </header>
    
    <nav id="navigation" class="clearfix">
    	<?php $nav->displayMainNavigation(); ?>
    </nav>
    
    <nav id="tabs" class="clearfix">
    	
    </nav>
    
    <section id="main" class="clearfix row">
       
        <article id="content">
            <?php require_once('forms/dashboard.php'); ?>
        </article>
        <aside id="sidebar">
        	<nav id="contentNavigation">
        		Hey this could be navigation if I need it. 
        	</nav>
            This is my side bar with shit in it.
        </aside>
    </section>
</section>

<?php 
	require_once('includes/footer.php');
?>
