<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	
	if (!empty($_GET['sel'])) {
		$refills = new Refills($_GET['sel']);
	} else {
		echo '<p>You have not selected a refill. Please try again.</p>';
		return;	
	}
	
	
?>

<h3 class="floatLeft">Refills</h3>

<div>
	<h4>Patient Information</h4>
	<dl class="clearfix">
    	<dt>Name:</dt>
        	<dd><?php echo $refills->name; ?></dd>
        <dt>Phone:</dt>
        	<dd><?php echo $refills->phone ?></dd>
        <dt>Email:</dt>
        	<dd><?php echo $refills->email; ?></dd>
	</dl>
    
    <h4>Prescription Information</h4>
    <dl class="clearfix">
    	<dt>Prescription Number:</dt>
        	<dd><?php echo $refills->number; ?></dd>
    	<dt>Delivery</dt>
        	<dd><?php echo ($refills->delivery ==1) ? 'Pick Up' : 'Delivery'; ?></dd>
    	<dt>Time Requested:</dt>
            	<dd><?php echo $refills->displayTime; ?></dd>
        <dt>Instructions:</dt>
            	<dd><?php echo $refills->special; ?></dd>
    </dl>
</div>

<div class="data"></div>

