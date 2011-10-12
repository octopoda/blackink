<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	$content = new Content();
	
	$pages = new Paginator('users');
	
?>


<h3 class="floatLeft">Site Content</h3>
<p><?php if (isset($_SESSION['error'])) echo $_SESSION['error']; ?></p>

<div class="contentList">
		<?php echo $pages->buildTable(); ?>
</div>
<div class="data">
</div>

