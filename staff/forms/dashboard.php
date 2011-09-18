<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); 

	if (isset($_GET['sel'])) {
		$menuId = $_GET['sel'];
		$link = 'forms/navigation/navigation.php?sel='.$menuId;
	} else {
		$menuId = 1;
		$link = 'forms/navigation/navigation.php?sel=1';
	}
	
?>
<script>
	$(function() {
	});
</script>

<section>
<h3 class="floatLeft">Dashboard</h3>
<p>
	

</p>
</section>


<div class="data">
</div>

