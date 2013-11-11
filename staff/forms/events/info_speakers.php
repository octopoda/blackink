<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	$users = new Users();
	
	if (!empty($_GET['sel'])) {
		$s = new Speakers($_GET['sel']);	
	} else {
		echo '<p>You have not selected a speaker. Please try again.</p>';
		return;	
	}
	
    $site = new Site();
	
	
	
?>

<ul class="quickMenu">
	<li><a href="forms/events/form_speakers.php?sel=<?php echo $s->speaker_id; ?>" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span> 
        	<span class="text">Edit Information</span>
         </a></li>
</ul>

<h3 class="floatLeft"><?php echo $s->speaker_name; ?></h3>

<div>
	<h4>Speaker Information</h4>
	<dl class="clearfix">
    	<dt>Speaker Image:</dt>
            <dd><img src="<?= $s->speaker_image; ?>" /></dd>
        <dt>Speaker Bio:</dt>
        	<dd><?= $s->bio; ?></dd>
        <dt>Facebook Link:</dt>
        	<dd><?= $s->facebook; ?></dd>
        <dt>Twitter Link:</dt>
        	<dd><?= $s->twitter; ?></dd>
        
    </dl>
</div>

<div class="data"></div>

