<?php require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); ?>


<h3 class="floatLeft">Photo Galleries</h3>

<ul class="quickMenu">
    <li><a class="redirect" href="forms/events/form_gallery.php">
        <span class="ninjaSymbol ninjaSymbolPlus"></span>
        <span class="text"> Add Gallery</span>
        </a>
    </li>
</ul>

<table class="grid editable" action="/ajax/grid_ajax.php" title="Default" sel="gallery">
    <tr>	
        <th col="gallery_name" link="forms/event/info_gallery.php">Gallery Title</th>
        <th col="published" width="80">published</th>
    </tr>
</table>

<div class="data"></div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid();
	});
</script>

