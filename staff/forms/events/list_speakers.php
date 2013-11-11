<?php require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); ?>


<h3 class="floatLeft">Speakers</h3>

<ul class="quickMenu">
    <li><a class="redirect" href="forms/events/form_speakers.php">
        <span class="ninjaSymbol ninjaSymbolPlus"></span>
        <span class="text"> Add Speaker</span>
        </a>
    </li>
</ul>

<table class="grid editable" action="/ajax/grid_ajax.php" title="Default" sel="speakers">
    <tr>	
        <th col="speaker_name" link="forms/events/info_speakers.php" width="300">Name</th>
        <th col="published" width="80">published</th>
    </tr>
</table>

<div class="data"></div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid();
	});
</script>

