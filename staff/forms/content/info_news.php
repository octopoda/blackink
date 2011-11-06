<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	
	if (!empty($_GET['sel'])) {
		$news = new NEws($_GET['sel']);
		$site = new Site();	
	} else {
		echo '<p>There is no selected Content. Please go back to search content and click a content title to view.</p>';
		return;	
	}
	
	$u = new Users($news->user_id);
	
	
?>

<ul class="quickMenu">
	<li><a href="forms/content/form_news.php?sel=<?php echo $news->news_id; ?>" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span> 
        	<span class="text">Edit Information</span>
         </a></li>
</ul>

<h3 class="floatLeft"><?php echo $news->title; ?></h3>

<div>
	<h4>News Information</h4>
	<dl class="clearfix">
    	<dt>News Content:</dt>
        	<dd><?php echo $news->content; ?></dd>
      	<dt>Direct Link:</dt>
        	<?php $link = str_replace(" ", "_", $news->title); ?>
            <dd><?php echo $site->siteURL.DS.'new'.DS.$news->title; ?></dd>
	</dl>
    
    <h4>Author Information</h4>
    <dl class="clearfix">
    	<dt>Author:</dt>
        	<dd><?php echo $u->printName(); ?></dd>
    	<dt>Created On:</dt>
        	<dd><?php echo $news->displayDate($news->created_on); ?></dd>
    </dl>
</div>

<div class="data"></div>

