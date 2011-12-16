<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	
	if (isset($_GET['sel'])) {
		$supplement = new Supplements($_GET['sel']);
	} else {
		echo '<h3>Please select a supplement from the supplement list.</h3>';	
	}
	
?>

<h3 class="floatLeft"><?php echo $supplement->ProductName ?> &mdash; Count: <?php echo $supplement->Count; ?></h3>

<dl>
<dt>Product Description:</dt>
<dd>
	<img src="<?php echo $supplement->ThumbnailImage; ?>" alt="<?php echo $supplement->ProductName; ?>" style="float:left; margin:0px 30px 30px 0px;" />
    <?php echo $supplement->ProductDescription; ?>
<dd>

<dt>Supplement Facts:</dt>
<dd><img src="<?php echo $supplement->SFB; ?>" alt="Supplement Information Facts" /></dd>

<dt>Suggested Use:</dt>
<dd><?php echo $supplement->SuggestedUse; ?></dd>

<dt>MSR Price:</dt>
<dd><?php echo $supplement->MSRP; ?></dd>
</dl> 






<div class="data"></div>

