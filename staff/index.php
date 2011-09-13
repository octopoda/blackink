<?php 
    require('includes/header.php');
	
    
    $nav = new AdminNavigation();
?>

<div id="siteWrapper">
    <header class="clearfix row">
       <hgroup>
           <h1>Black Ink</h1>
           <h2>Small Business Content Management System</h2>
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
    
    <div id="main" class="clearfix row">
       
        <div id="content">
            
        </div>
        <aside id="sidebar">
        	<nav id="contentNavigation">
        		Hey this could be navigation if I need it. 
        	</nav>
            This is my side bar with shit in it.
        </aside>
    </div>
	

<?php 
	require_once('includes/footer.php');
?>
