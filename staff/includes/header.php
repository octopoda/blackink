<?php
	require_once('admin_require.php');
?>

<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <meta charset="utf-8">
  <title><?php $site = new Site(); echo $site->siteName; ?> :: Octopoda Black Ink</title>
  <meta name="description" content="Black Ink Content management system made by OctopodaMedia.com">
  <meta name="author" content="Octopoda Media Inc. http://octopodamedia.com">
  <meta name="keywords" content=""  />

  <!-- <meta name="viewport" content="width=device-width"> -->

  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">

   <!-- CSS: implied media="all" -->
  <link rel="stylesheet" href="/staff/css/default.css" />
  <link rel="stylesheet" href="/staff/css/plugins.css" />
  <link rel="stylesheet" href="/staff/css/grid.css" />
  <link rel="stylesheet" href="/staff/css/admin.css" />

  <!-- Load Fonts -->
  <link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>

  <!-- modenrizr-->
  <script src="/js/libs/modernizr-2.5.2.min.js"></script>



</head>
<body>
<!-- Modal -->
   <div id="dialog" class="modal"></div>


