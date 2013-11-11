<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	$users = new Users();
	
	if (!empty($_GET['sel'])) {
		$fp = new Frontpage($_GET['sel']);	
	} else {
		echo '<p>You have not selected a video. Please try again.</p>';
		return;	
	}
	
    $site = new Site();
	
	
	
?>

<ul class="quickMenu">
	<li><a href="forms/frontpage/form_frontpage.php?sel=<?php echo $fp->page_id; ?>" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span> 
        	<span class="text">Edit Information</span>
         </a></li>
</ul>

<h3 class="floatLeft"><?php echo $fp->title; ?></h3>

<div>
	<h4>Front Page Image Information</h4>
	<dl class="clearfix">
    	<dt>Link:</dt>
            <dd><?php echo $fp->link; ?></dd>
        <dt>Image:</dt>
            <dd><img src="<?php echo $fp->image; ?>" width="300" /></dd>
        <dt>Content:</dt>
            <dd><?php echo $fp->content; ?></dd>
    </dl>
</div>

<div class="data"></div>

