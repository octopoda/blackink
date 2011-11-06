<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	
	$site = new Site();
?>

<ul class="quickMenu">
	<li><a href="forms/site/form_site.php" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span> 
        	<span class="text">Edit Information</span>
         </a></li>
</ul>

<h3 class="floatLeft">Site Information</h3>

<div>
	<dl class="clearfix">
    	<dt>Site Name:</dt>
        	<dd><?php echo $site->siteName; ?></dd>
      	<dt>Site URL:</dt>
        	<dd><?php echo $site->siteURL; ?></dd>
	</dl>
 	
 	<h4>Search Engine Information</h4>
    <dl class="clearfix">
    	<dt>Site Description</dt>
        	<dd><?php echo $site->siteDescription; ?></dd>
		<dt>Keywords:</dt>
        	<dd><?php echo $site->keywords; ?></dd>
        <dt>Google Anaylitics ID #:</dt>
        	<dd><?php echo $site->googleCode; ?></dd>
    	
    </dl>
</div>

<div class="data"></div>

