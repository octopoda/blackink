<?php
	$title = "";
	$name = ""; 
	$drug = "";
	
	if (isset($_GET['title']))
		$title = $_GET['title'];
	if (isset($_GET['name']))
		$name = $_GET['name'];
	if (isset($_GET['drug']))
		$drug = $_GET['drug'];
	
	$display = new Display($title, $name, $drug);
	$detect = new MobileDetect(); 
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="<?php if($detect->isMobile()) echo 'mobile'; ?> no-js "  lang="en"> <!--<![endif]--><head> 
 
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
  	
  <meta charset="utf-8">
  <title><?php echo $site->siteName . $display->displayPageTitle(); ?> :: Compounding Compass</title>
  <meta name="description" content="<?php echo $display->displayPageDescription(); ?>">
  <meta name="author" content="Octopoda Media Inc. http://octopodamedia.com">
  <meta name="keywords" content="<?php echo $site->keywords; ?>"  />
  	
  <meta name = "viewport" content = "initial-scale=1.0, width=device-width">
  <meta name="apple-mobile-web-app-capable" content="yes"/>


  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
	
  <!-- CSS: implied media="all" -->
  <link rel="stylesheet" href="/css/basic.css"  />
  <link rel="stylesheet" href="/css/plugins.css"  />
  <link rel="stylesheet" href="/css/desktop.css" media="only screen and (min-width: 1024px)" />
  
  <link rel="stylesheet" href="/css/tablet.css" media="only screen and (max-width:1024px) and (min-width:480px;)" />

  <link rel="stylesheet" href="/css/mobile.css" media="only screen and (max-width:480px)" />
    <!--[if gt IE 9]>
  <![endif]-->

  
  
  <!-- Font Stylesheets -->
  
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'> 
  
    
  <script src="/js/libs/modernizr-2.0.6.min.js"></script>
  
  
</head>

<body class"<?php if($title == 'compass') echo 'compass'; ?>"  >
<div id="dialog"></div>
    <header>
    	<div class="row">
            <hgroup>
                    <h1><a href="/index.php" class="ir logo"><?php echo $site->siteName; ?></a></h1>
            </hgroup>
            <nav class="quickNav">
            	
                <?php
					//if (!$detect->isMobile()) {
					 $display->displayMenu('Quick Menu');
					//} else {
						//echo '<a href="/login.html" class="mobileQuickMenu">Login</a>';			
					//}
				?>
            </nav>
        </div>
   </header>
   <nav class="mainNav">
   		<div class="row">
			<?php 
				if ($title != 'compass') $display->displayMenu('Main Menu');
				else $display->displayMenu('Compounding Compass')
			 ?>
        </div>
   </nav>
	