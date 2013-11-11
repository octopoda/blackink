<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	$users = new Users();
	
	if (!empty($_GET['sel'])) {
		$v = new Videos($_GET['sel']);	
	} else {
		echo '<p>You have not selected a video. Please try again.</p>';
		return;	
	}
	
    $site = new Site();
	
	
	
?>

<ul class="quickMenu">
	<li><a href="forms/videos/form_videos.php?sel=<?php echo $v->video_id; ?>" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span> 
        	<span class="text">Edit Information</span>
         </a></li>
</ul>

<h3 class="floatLeft"><?php echo $v->title; ?></h3>

<div>
	<h4>Video Information</h4>
	<dl class="clearfix">
    	<dt>Share Link:</dt>
            <dd><?php echo $v->shareLink; ?></dd>
        <dt>Poster Image:</dt>
            <dd><img src="<?php echo $v->posterImage; ?>" /></dd>
        <dt>Published On</dt>
            <dd><?php echo $v->displayDate($v->publishDate); ?></dd>
        <dt>Direct Link</dt>
            <dd>http:// <?php echo $site->siteURL.DS.'videos'.DS.$v->directLink; ?></dd>
    </dl>
</div>

<div class="data"></div>

