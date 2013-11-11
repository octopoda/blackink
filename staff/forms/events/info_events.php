<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	$users = new Users();
	
	if (!empty($_GET['sel'])) {
		$e = new Events($_GET['sel']);	
	} else {
		echo '<p>You have not selected an event. Please try again.</p>';
		return;	
	}
	
    $site = new Site();
	$address = new Address();
	
	
?>

<ul class="quickMenu">
	<li><a href="forms/events/form_events.php?sel=<?php echo $e->event_id; ?>" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span> 
        	<span class="text">Edit Information</span>
         </a></li>
</ul>

<h3 class="floatLeft"><?php echo $e->event_name; ?></h3>

<div>
	<h4>Event Information</h4>
	<dl class="clearfix">
    	<dt>Event Dates:</dt>
            <dd><?= $e->showDate(); ?></dd>
        <dt>Event Location:</dt>
            <dd><?= $e->location. ', ' . Address::getState($e->state_id); ?></dd>
        <dt>Description</dt>
			<dd><?= $e->content; ?></dd>
	    <dt>Direct Link</dt>
            <dd>http:// <?php echo $site->siteURL.$e->directLink; ?></dd>
		<dt>Color Scheme:</dt>
		<dd><?= $e->readableColor($e->color); ?></dd>
		<dt>Header Image:</dt>
		<dd><img src="<?= $e->header_image; ?>" alt="<?php $e->event_name; ?>"></dd>
	</dl>


	<h4>Speakers</h4>
	<dl class="clearfix">

    	<dt>Speakers:</dt>

    	<dd>
    		<?php if ($e->speakers != false) : ?>
    			<ul>
	           	<?php foreach($e->speakers as $speaker) { ?>
					<li><?= $speaker->speaker_name; ?></li>
	           	<?php } ?>	
       			</ul>
			<?php else: ?>
				<dd>There are no speakers associated with this event.</dd>
			<? endif; ?>
   		</dd>
	</dl>

	<h4>Band Information</h4>
	<dl class="clearfix">
    	<dt>Band:</dt>
    	<dd><?= $e->band_name; ?></dd>
    	<dt>Band Image:</dt>
    	<dd><img src="<?= $e->band_file; ?>" alt=""></dd>
		<dt>Band Facebook:</dt>
    	<dd><?= $e->band_facebook; ?></dd>
    	<dt>Band Twitter:</dt>
    	<dd><?= $e->band_twitter; ?></dd>

	</dl>

	<h4>Drama Information</h4>
	<dl class="clearfix">
    	<dt>drama:</dt>
    	<dd><?= $e->drama_name; ?></dd>
    	<dt>drama Image:</dt>
    	<dd><img src="<?= $e->drama_file; ?>" alt=""></dd>
		<dt>drama Facebook:</dt>
    	<dd><?= $e->drama_facebook; ?></dd>
    	<dt>drama Twitter:</dt>
    	<dd><?= $e->drama_twitter; ?></dd>

	</dl>

</div>

<div class="data"></div>

