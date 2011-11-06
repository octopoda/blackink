<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	
	if (!empty($_GET['sel'])) {
		$ads = new Ads($_GET['sel']);
		$site = new Site();	
	} else {
		echo '<p>There is no selected Advertisment. Please go back to search Ads and click a ads title to view.</p>';
		return;	
	}
	
	$u = new Users($ads->user_id);
?>

<ul class="quickMenu">
	<li><a href="forms/content/form_content.php?sel=<?php echo $ads->ad_id; ?>" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span> 
        	<span class="text">Edit Information</span>
         </a></li>
</ul>

<h3 class="floatLeft"><?php echo $ads->title; ?></h3>

<div>
	<h4>Content Information</h4>
	<dl class="clearfix">
    	<dt>Content:</dt>
        	<dd><?php echo $ads->content; ?></dd>
        <dt>Front Page/Sidebar Summary:</dt>
        	<dd><?php echo !empty($ads->summary) ? $ads->summary :  'No summary added'; ?></dd>
        <dt>Direct Link:</dt>
        	<?php $link = str_replace(" ", "_", $ads->title); ?>
        	<dd><?php echo $site->siteURL.DS.'ads'.DS.$link; ?></dd>
	</dl>
    
    <h4>Author Information</h4>
    <dl class="clearfix">
    	<dt>Author:</dt>
        	<dd><?php echo $u->printName(); ?></dd>
    </dl>
</div>

<div class="data"></div>

