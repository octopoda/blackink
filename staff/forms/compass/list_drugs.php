<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	$content = new Content();
?>
<ul class="quickMenu">
	<li><a class="redirect" href="forms/compass/form_drugs.php">
		<span class="ninjaSymbol ninjaSymbolPlus"></span>
		<span class="text"> Add Content</span>
		</a>
	</li>
</ul>

<h3>Site Content</h3>

<table class="grid" action="/ajax/grid_ajax.php" title="Default" sel="drugs">
    <tr>	
        <th col="drugName" link="forms/compass/info_drugs.php">Drug Name</th>
       	<th col="published">Published</th>
        <th col="user_id">Author</th>
        <th col="modified_on">Last Edited</th>
        <th col="access">Access</th>
    </tr>
</table>
<div class="data"></div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid();
	});
</script>

