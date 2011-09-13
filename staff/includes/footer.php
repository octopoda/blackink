   <footer>
   <?php 
		curPageURL();
		if ($pageTitle != 'Login')
		echo '<ul class="bottomNav">
			<li><a href="forms/report_errors.php" class="report">Report Errors</a></li>
        	<li><a href="logout.php">Logout</a></li>
        	<li>&copy 2010 - '.date('Y') .' Octopoda Inc.  All Rights Reserved.</li>
		</ul>'
	?>
    </footer>
</div><!-- End SiteWrapper -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>
	
  <script defer src="/js/admin/admin_functions.js"></script>
  <script defer src="/js/script.js"></script>
  <script defer src="/js/libs/ckeditor/ckeditor.js"></script>
  <script defer src="/js/libs/ckeditor/adapters/jquery.js"></script>
  
  <?php if (SERVER == 'dev') { ?>
		 <script src="/js/mylibs/live.js"></script>	  
  <?php } ?>
  <!-- end scripts-->

 <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->

</body>
</html>