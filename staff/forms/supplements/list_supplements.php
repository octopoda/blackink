<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
?>
<ul class="quickMenu">
	<li><a class="reloadSupplements" href="#">
		<span class="ninjaSymbol ninjaSymbolPlus"></span>
		<span class="text"> Reload Supplements</span>
		</a>
	</li>
</ul>

<h3>Orthomolecular Supplements</h3>
<table class="grid" action="/ajax/grid_ajax.php" sel="supplements">
    <tr>	
        <th col="ItemNumber" width="60">Item Number</th>
        <th col="ProductName" width="200" link="forms/supplements/info_supplements.php">Name</th>
        <th col="featured" width="50">Featured</th>
        <th col="frontpage" width="50">Front Page</th>
        <th col="MSRP" width="60">Price</th>
    </tr>
</table>
<div class="data"></div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid({
			order_by: 'ProductName',
			sort: 'ASC'	
		});
	});
</script>

