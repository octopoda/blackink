<?php
	$title = "";
	$name = ""; 
	
	if (isset($_GET['title']))
		$title = $_GET['title'];
	if (isset($_GET['name']))
		$name = $_GET['name'];
	
	$display = new Display($title, $name);
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  	
  <meta charset="utf-8">
  <title><?php echo $site->siteName . $display->displayPageTitle(); ?></title>
  <meta name="description" content="<?php echo $site->siteDescription; ?>">
  <meta name="author" content="Octopoda Media Inc. http://octopodamedia.com">
  <meta name="keywords" content="<?php echo $site->keywords; ?>"  />
  	
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
	
   <!-- CSS: implied media="all" -->
  <script src="/js/libs/modernizr-2.0.6.min.js"></script>

</head>

<body>
<div id="siteWrapper">
    <header>

    </header>