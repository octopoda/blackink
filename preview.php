<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); 
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');
	
	if (isset($_SESSION['content'])) {
		$title = $_SESSION['title'];
		$content = $_SESSION['content'];	
	} else {
		$action = 1;
	}
?>

<section class="mainContent">
	<article>
    	<?php 
			if (isset($action)) {
				echo 'There is no content to preview';	
			} else {
				echo '<h1>'.$title."</h1>";
				echo $content;		
			}
		?>
    </article>
    
    
    <aside>
    	<?php include(MODULES.'sidebar.php'); ?>
    </aside>
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>        
       