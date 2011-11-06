<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	
?>

<ul class="quickMenu">
	<li><a href="forms/content/form_ads.php" class="redirect">
		<span class="ninjaSymbol ninjaSymbolPlus"></span>
		<span class="text"> Add a New Ad</span>
		</a>
	</li>
</ul>

<h3>Your Advertisements</h3>
<p></p>
<table class="grid" action="/ajax/grid_ajax.php" title="Default" sel="ads">
    <tr>	
        <th col="title" width="250" link="forms/content/info_ads.php">Title</th>
        <th col="published" width="50">Published</th>
        <th col="position" width="40" class="gridPosition">position</th>
        <th col="placement" width="50">Placement</th>
        <th col="user_id" width="100">Author</th>
    </tr>
</table>
<div class="data">
</div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid({
			order_by: 'position'	
		});
	});
</script>

