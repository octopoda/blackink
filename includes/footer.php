    <footer>
    	<div class="row">
			<?php $contactInformation = new ContactInformation(); ?>
            <section class="about eightcol">
                <?php echo $contactInformation->summary; ?>
                <p class="legal">&copy; 2007- <?php echo date("Y") ?> Innovation Compounding Inc, All Rights Reserved.</p>
            </section>
            <section class="footerContact fourcol last">
                <h5>Visit Us</h5>
                <p><?php echo $contactInformation->address->printAddress(); ?></p>
                
                <h5>Email Us</h5>
                <a href="/contact_us.html">Click here to send an email.</a>
                
                <h5>Call Us</h5>
                <?php echo $contactInformation->printPhones(); ?>
            </section>
        </div>
    </footer>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>
	
  <script defer src="/js/plugins.js"></script>
  <script defer src="/js/script.js"></script>
  <!-- end scripts-->

  <?php if (SERVER == 'dev') { ?>
		 <script src="/js/mylibs/live.js"></script>	  
  <?php } else { ?>
  
  <!-- mathiasbynens.be/notes/async-analytics-snippet Change UA-XXXXX-X to be your site's ID -->
 <?php if ((!empty($site->googleCode)) && (SERVER == 'live')) : ?>
  <script>
    window._gaq = [['_setAccount','<?php echo $site->googleCode; ?>'],['_trackPageview'],['_trackPageLoadTime']];
    Modernizr.load({
      load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
    });
  </script>
  <?php endif; ?>


  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <?php } ?>	
</body>
</html>
 
        

