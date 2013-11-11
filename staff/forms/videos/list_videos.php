<?php require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); ?>


<h3 class="floatLeft">Videos</h3>

<ul class="quickMenu">
    <li><a class="redirect" href="forms/videos/form_videos.php">
        <span class="ninjaSymbol ninjaSymbolPlus"></span>
        <span class="text"> Add Video</span>
        </a>
    </li>
</ul>

<table class="grid editable" action="/ajax/grid_ajax.php" title="Default" sel="videos">
    <tr>	
        <th col="title" link="forms/videos/info_videos.php">Title</th>
        <th col="published" width="80">published</th>
        <th col="publishDate">Published On</th>
        <th col="access" width="100" editable="select">Access</th>
    </tr>
</table>

<div class="data"></div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid();
	});
</script>

