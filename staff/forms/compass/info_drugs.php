<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	$contentsers = new Users();
	
	if (!empty($_GET['sel'])) {
		$drugs = new Drugs($_GET['sel']);
		$modDrugs = new Drugs($_GET['sel']);
		$site = new Site();	
	} else {
		echo '<p>There is no selected compass content. Please go back to search content and click a content title to view.</p>';
		return;	
	}
	
	$u = new Users($drugs->user_id);
	
	if (!empty($modDrugs->modified_by)) {
		$modUsers = new Users($modDrugs->modified_by);
		$modName = $modUsers->printName();
		$modId = $modUsers->user_id;
	}
?>

<ul class="quickMenu">
	<li><a href="forms/compass/form_drugs.php?sel=<?php echo $drugs->drug_id; ?>" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span> 
        	<span class="text">Edit Information</span>
         </a></li>
</ul>

<h3 class="floatLeft"><?php echo $drugs->drugName; ?></h3>

<div>
	<h4>Compass Category of Treatment </h4>
	<dl class="clearfix">
    	<dt>Drug Name:</dt>
        	<dd><?php echo $drugs->drugName; ?></dd>
        <dt>Drug Use:</dt>
        	<dd><?php echo $drugs->drugUse; ?></dd>
        <dt>Content:</dt>
        	<dd><?php echo $drugs->content; ?></dd>
        <dt>Direct Link:</dt>
        	<dd><?php echo $site->siteURL.$drugs->directLink ?></dd>
	</dl>
    
    <h4>Author Information</h4>
    <dl class="clearfix">
    	<dt>Author:</dt>
        	<dd><?php echo $u->printName(); ?></dd>
    	<dt>Created On:</dt>
        	<dd><?php echo $drugs->displayDate($drugs->created_on); ?></dd>
    	<?php if (!empty($modName) && ($modId != $drugs->user_id)) : ?>
        	<dt>Modified By:</dt>
            	<dd><?php echo $modName ?></dd>
        <?php endif; ?>
        <?php if (!empty($drugs->modified_on)) : ?>
        	<dt>Modified On:</dt>
            	<dd><?php echo $drugs->displayDate($drugs->modified_on); ?></dd>
        <?php endif; ?>
    </dl>
</div>

<div class="data"></div>

