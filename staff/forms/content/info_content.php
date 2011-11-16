<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	$contentsers = new Users();
	
	if (!empty($_GET['sel'])) {
		$content = new Content($_GET['sel']);
		$modContent = new Content($_GET['sel']);
		$site = new Site();	
	} else {
		echo '<p>There is no selected Content. Please go back to search content and click a content title to view.</p>';
		return;	
	}
	
	$u = new Users($content->user_id);
	
	if (!empty($modContent->modified_by)) {
		$modUsers = new Users($modContent->modified_by);
		$modName = $modUsers->printName();
		$modId = $modUsers->user_id;
	}
?>

<ul class="quickMenu">
	<li><a href="forms/content/form_content.php?sel=<?php echo $content->content_id; ?>" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span> 
        	<span class="text">Edit Information</span>
         </a></li>
</ul>

<h3 class="floatLeft"><?php echo $content->title; ?></h3>

<div>
	<h4>Content Information</h4>
	<dl class="clearfix">
    	<dt>Content:</dt>
        	<dd><?php echo $content->content; ?></dd>
        <dt>Search Engine Summary:</dt>
        	<dd><?php echo !empty($content->summary) ? $content->summary :  'No summary added'; ?></dd>
        <dt>Direct Link:</dt>
        	<?php $link = str_replace(" ", "_", $content->title); ?>
            <dd><?php echo $site->siteURL.$content->directLink ?></dd>
	</dl>
    
    <h4>Author Information</h4>
    <dl class="clearfix">
    	<dt>Author:</dt>
        	<dd><?php echo $u->printName(); ?></dd>
    	<dt>Created On:</dt>
        	<dd><?php echo $content->displayDate($content->created_on); ?></dd>
    	<?php if (!empty($modName) && ($modId != $content->user_id)) : ?>
        	<dt>Modified By:</dt>
            	<dd><?php echo $modName ?></dd>
        <?php endif; ?>
        <?php if (!empty($content->modified_on)) : ?>
        	<dt>Modified On:</dt>
            	<dd><?php echo $content->displayDate($content->modified_on); ?></dd>
        <?php endif; ?>
    </dl>
</div>

<div class="data"></div>

