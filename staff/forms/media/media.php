<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	
	$media = new Media();
?>
<ul class="quickMenu">
	<li><a class="redirect" href="forms/media/upload.php">
		<span class="ninjaSymbol ninjaSymbolPlus"></span>
		<span class="text"> Upload File</span>
		</a>
	</li>
</ul>

<h3>Current Uploaded Media</h3>
        
 <table class="grid thumbs" action="/ajax/grid_ajax.php" title="Default" sel="media">
    <tr>	
        <th col="thumbs" type="image" width="30">Thumbnails</th>
        <th col="file_name" width="40%">Title</th>
        <th col="file_link" width="10%">File Link</th>
    </tr>
</table>       
        

  <div class="data"></div>  
	    
    

<script type="text/javascript">
$(document).ready(function () { $(".grid").loadGrid();});
</script>


