   <footer>
   
   
   <?php 
		curPageURL();
		if ($pageTitle != 'Login')
		echo '<ul class="bottomNav">
			<li><a href="forms/site/form_report_errors.php" class="redirect">Report Errors</a></li>
        	<li><a href="logout.php">Logout</a></li>
			<li>Black Ink CMS System 1.0.1::</li>
        	<li>&copy 2010 - '.date('Y') .' Octopoda Inc.  All Rights Reserved.</li>
		</ul>'
	?>
    </footer>
</div><!-- End SiteWrapper -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>

  <script src="/js/plugins.js"></script>
  <script src="/js/admin/admin_functions.js"></script>
  <script src="/js/libs/tiny_mce/tiny_mce.js"></script> 
  
  <?php if (SERVER == 'dev') { ?>
		<script src="/js/mylibs/live.js"></script>
  <?php } ?>


</body>
</html>