<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	
	$social = new Social();
	$none = 'Not Added';
?>

<ul class="quickMenu">
	<li><a href="forms/site/form_social.php" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span> 
        	<span class="text">Edit Information</span>
         </a></li>
</ul>

<h3 class="floatLeft">Social Networks</h3>

<div>
	<h4>Social URL Information</h4>
    <dl class="clearfix">
    
    	<dt>Facebook URL:</dt>
        	<dd><?php echo (isset($social->facebook_url)) ? $social->facebook_url : $none; ?></dd>
        <dt>Twitter URL:</dt>
        	<dd><?php echo (isset($social->twitter_url)) ? $social->twitter_url : $none; ?></dd>
		<dt>Linked In URL:</dt>
        	<dd><?php echo (isset($social->linkedin_url)) ? $social->linkedin_url : $none; ?></dd>
        <dt>Google + URL:</dt>
        	<dd><?php echo (isset($social->google_url)) ? $social->google_url : $none; ?></dd>    
        <dt>Tumblr URL:</dt>
        	<dd><?php echo (isset($social->tumblr_url)) ? $social->tumblr_url : $none; ?></dd> 
        <dt>Foursquare URL:</dt>
        	<dd><?php echo (isset($social->foursquare_url)) ? $social->foursquare_url : $none; ?></dd>
        <dt>Last FM URL:</dt>
        	<dd><?php echo (isset($social->last_fm_url)) ? $social->last_fm_url : $none; ?></dd>
           
    </dl>
</div>

<div class="data"></div>

