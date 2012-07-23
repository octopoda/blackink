<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/require.php');
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php'); 
 ?>
 


 <section class="mainContent">
	<div class="row">
       <article class="eightcol">
           	<h1>Your account has been created.</h1>
 			
 			<p>We will just need to confirm your NPI Number and give you access to the compounding compass.  Once you have been approved you will recieve an email.  </p>

 			<p>If you have any questions please feel free to <a href="/contact_us.html">contact us</a>. </p>

 			<a href="/index.html" class="button">Back Home</a> 
		 	
		</article>
        
        
        <aside class="fourcol last">
            <?php include(MODULES.'sidebar.php'); ?>
        </aside>
    </div>
</section>
 
 <?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>