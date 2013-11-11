<?php require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); ?>


<h3 class="floatLeft">Events</h3>

<ul class="quickMenu">
    <li><a class="redirect" href="forms/events/form_events.php">
        <span class="ninjaSymbol ninjaSymbolPlus"></span>
        <span class="text"> Add Event</span>
        </a>
    </li>
</ul>

<table class="grid editable" action="/ajax/grid_ajax.php" title="Default" sel="events">
    <tr>	
    <th col="event_name" link="forms/events/info_events.php">Event</th>
        <th col="published" width="80">published</th>
        <th col="start_date" width="100">Date</th>
    </tr>
</table>

<div class="data"></div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid();
	});
</script>

