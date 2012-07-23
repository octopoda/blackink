<?php 
    require('includes/header.php');
	
	//Auth
	if (!isset($_SESSION['user_id'])) redirect('login.php');
	else if ($users->access < 3) redirect('/no_access.html');	
	
	//Set Classes
	$nav = new AdminNavigation();
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
        	 <h4>Need some help? </h4>
            
            <!--<p>Checkout the how to video page.</p> -->
            <p>Maybe you need some help styling.  <a target="_blank" href="/style_guide.html">Look through your style guide.</a> </p>
            <p>If you still need help hit the report errors button at the bottom of the page and send Zack and email.  He'll get back to you as soon as he can. </p>
        </aside>
    </section>
</section>

<?php 
	require_once('includes/footer.php');
?>
