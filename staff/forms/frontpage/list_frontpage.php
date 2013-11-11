<?php require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); ?>


<h3 class="floatLeft">Front Page</h3>

<ul class="quickMenu">
    <li><a class="redirect" href="forms/frontpage/form_frontpage.php">
        <span class="ninjaSymbol ninjaSymbolPlus"></span>
        <span class="text"> Add Front Page Image</span>
        </a>
    </li>
</ul>

<table class="grid editable" action="/ajax/grid_ajax.php" title="Default" sel="frontpage">
    <tr>
        <th col="title" link="forms/frontpage/info_frontpage.php">Title</th>
        <th col="published" width="80">published</th>
        <th col="position" width="100">position</th>
        <th col="link">Link</th>
    </tr>
</table>

<div class="data"></div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid({
            order_by: 'position',
            sort: 'DESC'
        });
	});
</script>

