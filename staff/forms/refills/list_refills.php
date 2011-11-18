<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
?>


<h3>Prescription Refills</h3>
<table class="grid" action="/ajax/grid_ajax.php" sel="refills">
    <tr>	
        <th col="number" link="forms/refills/info_refills.php">Prescription #</th>
        <th col="name" >Name</th>
        <th col="email">Email</th>
        <th col="time">Time Requested</th>
        <th col="phone">Phone</th>
    </tr>
</table>
<div class="data"></div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid({
			order_by: 'time',
			sort: 'desc'	
		});
	});
</script>

