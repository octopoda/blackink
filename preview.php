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
	<div class="row">
        <article>
            <?php 
                if (isset($action)) {
                    echo '<h3>There is no content to preview</h3>';	
                } else {
                    echo '<h1>'.$title."</h1>";
                    echo $content;		
                }
            ?>
        </article>
        
        
        <aside>
            <?php include(MODULES.'sidebar.php'); ?>
        </aside>
    </div>
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>        
       