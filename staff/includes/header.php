<?php 
	require_once('admin_require.php');
?>

<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  	
  <meta charset="utf-8">
  <title><?php $site = new Site(); echo $site->siteName; ?> :: Octopoda Black Ink</title>
  <meta name="description" content="Black Ink Content management system made by OctopodaMedia.com">
  <meta name="author" content="Octopoda Media Inc. http://octopodamedia.com">
  <meta name="keywords" content=""  />
  	
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
	
   <!-- CSS: implied media="all" -->
  <link rel="stylesheet" href="css/default.css" />
  <link rel="stylesheet" href="/css/plugins.css" />
  <link rel="stylesheet" href="css/grid.css" />
  <link rel="stylesheet" href="css/admin.css" />
  
  <!-- Load Fonts -->
  <link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
  
</head>
<body>
<!-- Modal -->
   <div id="dialog" class="modal"></div>


