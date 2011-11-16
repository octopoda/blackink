    <footer>
    
    </footer>
</div> <!--! end of #siteWrapper -->

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>
	
  <script defer src="/js/plugins.js"></script>
  <script defer src="/js/script.js"></script>
  <script src="/js/mylibs/blackink_modal_min.js"></script>
  <script src="/js/mylibs/validation.js"></script>
  <script type="text/javascript" src="/js/libs/jquery.autocomplete.js"></script>
  <!-- end scripts-->

  <?php if (SERVER == 'dev') { ?>
		 <script src="/js/mylibs/live.js"></script>	  
  <?php } else { ?>
  
  <!-- mathiasbynens.be/notes/async-analytics-snippet Change UA-XXXXX-X to be your site's ID -->
  <script>
    window._gaq = [['_setAccount','<?php echo $site->googleCode; ?>'],['_trackPageview'],['_trackPageLoadTime']];
    Modernizr.load({
      load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
    });
  </script>


  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <?php } ?>	
</body>
</html>
 
        

